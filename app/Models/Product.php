<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Product extends Model implements Searchable
{
    use HasFactory;
    use SoftDeletes;
    //use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'tax_id', 'title', 'price', 'description', 'weight'
    ];

    protected $appends = ['sale_price', 'has_sale'];

    public $searchableType = 'Produit';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) { // before delete() method call this
            $date = $product->created_at->format('Y/m/');
            $extension = $product->image->extension;
            $file_name = $product->image->file_name . '.' . $extension;
            if ($product->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name))) {
                    File::delete(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name));

                    for ($i = 1; $i <= 5; $i++) {
                        $size = get_image_size($i, true);
                        $filename = $file_name . '-' . $size[0] . 'w.' . $extension;
                        if (File::exists(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename))) {
                            File::delete(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename));
                        }
                    }
                }
            }
        });
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('products.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * gets the price value and formats it with two digits
     *
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2, '.', ' ');
    }

    public function sellers()
    {
        return $this->belongsToMany(User::class, 'product_user')->withPivot('user_id');
    }

    public function customers()
    {
        return $this->belongsToMany(User::class, 'product_customer')->withTimestamps()->withPivot('user_id');
    }

    public function getCustomersCountAttribute()
    {
        return $this->customers()->count();
    }

    /**
     * price value is always set using money format 2 digets
     *
     * @param $value
     */
    public function setPriceAttribute($value)
    {

        $this->attributes['price'] = number_format($value, 2, '.', ' ');
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }
    /**
     * is the product on sale
     *
     * @return bool
     */
    public function hasSale()
    {
        $current = $this->sales
            ->where('start', '<=', Carbon::now()->format('Y-m-d'))
            ->where('finish', '>=', Carbon::now()->format('Y-m-d'))
            ->count();
        return ($current >= 1) ? true : false;
    }

    public function getHasSaleAttribute()
    {
        return $this->hasSale();
    }

    /**
     * returns the sale price
     *
     * @return string
     */
    public function salePrice()
    {
        return false;
        $discount = 1 - $this->sales()->current()->first()->discount;

        return number_format($this->price * $discount, 2);
    }

    public function getsalePriceAttribute()
    {
        return $this->salePrice();
    }

    /**
     * a product belongs to a category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * a product has many reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }

    public function featured_image($num_size = null)
    {

        $date = $this->created_at->format('Y/m/');

        $extension = last(explode('.', $this->image->name));

        return $date . $this->image->file_name . '-' . get_image_size($num_size) . '.' . $extension;
    }
    /**
     * a product has a tax
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * a product can have many sales
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * performs a search if algolia is not used
     * comment out if algolia is used
     *
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->where('title', 'like', "%$query%");
    }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
