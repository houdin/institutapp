<?php

namespace App\Models;

use App\Models\Formation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'icon', 'status', 'parent_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'pivot', 'status', 'deleted_at',
    ];

    protected $appends = [
        'total'
    ];

    protected $guarded = [];

    public function getTotalAttribute()
    {

        $count = 0;
        // $count = $this->formations->count();
        // $count += $this->tutorials->count();
        // $count += $this->bundles->count();
        $count += $this->blogs->count();
        // $count += $this->faqs->count();
        // $count += $this->portfolios->count();
        // $count += $this->tipstricks->count();
        // $count += $this->children->count();

        // $count += $this->products->count();

        return $count;
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class);
    }

    public function tutorials()
    {
        return $this->belongsToMany(Tutorial::class);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'category_blog');
    }

    public function faqs()
    {
        return $this->belongsToMany(Faq::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function tipstricks()
    {
        return $this->belongsToMany(Tipstrick::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords($value),
        );
    }

    public function parentId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
        );
    }

    // public function getParentAttribute()
    // {
    //     return $this->belongsTo(Category::class, 'parent_id');
    // }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
}
