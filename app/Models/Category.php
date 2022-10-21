<?php

namespace App\Models;

use App\Models\Formation;
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
        'created_at', 'updated_at', 'status', 'formations', 'tutorials', 'bundles', 'blogs', 'portfolios', 'tipstricks', 'products'
    ];

    protected $appends = [
        'parent', 'total'
    ];

    protected $guarded = [];

    public function getTotalAttribute()
    {

        $count = $this->formations->count();
        $count += $this->tutorials->count();
        $count += $this->bundles->count();
        $count += $this->blogs->count();
        $count += $this->faqs->count();
        $count += $this->portfolios->count();
        $count += $this->tipstricks->count();
        $count += $this->children->count();

        $count += $this->products->count();

        return $count;
    }

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function tipstricks()
    {
        return $this->hasMany(Tipstrick::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function getParentAttribute()
    {
        return $this->attributes['parent_id'];
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
}
