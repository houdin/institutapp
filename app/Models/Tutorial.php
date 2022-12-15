<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Auth\User;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Tutorial
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property decimal $price
 * @property string $tutorial_image
 * @property string $start_date
 * @property tinyInteger $published
 */

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Tutorial extends Model implements Searchable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = ['category_id', 'title', 'slug', 'description', 'price', 'image_id', 'tutorial_video', 'start_date', 'published', 'free', 'featured', 'trending', 'popular', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $appends = ['students_count'];

    protected $tutorial_image;

    public $searchableType = 'Tutoriel';

    protected static function boot()
    {
        parent::boot();
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('teachers', function ($q) {
                        $q->where('tutorial_user.user_id', '=', auth()->user()->id);
                    });
                });
            }
        }

        static::deleting(function ($tutorial) { // before delete() method call this
            $date = $tutorial->created_at->format('Y/m/');
            $extension = $tutorial->image->extension;
            $file_name = $tutorial->image->file_name . '.' . $extension;
            if ($tutorial->isForceDeleting()) {
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
        $url = route('tutorials.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    // public function getImageAttribute()
    // {
    //     return $this->image();
    // }


    public function getPriceAttribute()
    {
        if (($this->attributes['price'] == null)) {
            return round(0.00);
        }
        return $this->attributes['price'];
    }


    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'tutorial_user')->withPivot('user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'tutorial_student')->withTimestamps()->withPivot(['rating']);
    }

    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
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

    public function scopeOfTeacher($query)
    {
        if (!Auth::user()->isAdmin()) {
            return $query->whereHas('teachers', function ($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        return $query;
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function getIsAddedToCart()
    {
        if (auth()->check() && (auth()->user()->hasRole('student')) && (\Cart::session(auth()->user()->id)->get($this->id))) {
            return true;
        }
        return false;
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function isUserCertified()
    {
        $status = false;
        $certified = auth()->user()->certificates()->where('tutorial_id', '=', $this->id)->first();
        if ($certified != null) {
            $status = true;
        }
        return $status;
    }

    public function item()
    {
        return $this->morphMany(OrderItem::class, 'item');
    }

    public function mediaVideo()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed'];
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', $types);
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
