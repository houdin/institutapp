<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bundle extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;


    protected $fillable = ['category_id', 'title', 'slug', 'description', 'price', 'formation_image', 'start_date', 'published', 'free', 'featured', 'trending', 'popular', 'meta_title', 'meta_description', 'meta_keywords', 'user_id'];

    protected $appends = [];

    protected $hidden = ['pivot'];

    //protected $with = ['formations:id,title,slug'];


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($bundle) { // before delete() method call this
            if ($bundle->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/fmts/' . $bundle->formation_image))) {
                    File::delete(public_path('/storage/uploads/fmts/' . $bundle->formation_image));
                    File::delete(public_path('/storage/uploads/fmts/thumb/' . $bundle->formation_image));
                }
            }
        });
    }

    public function scopeOfTeacher($query)
    {
        if (!Auth::user()->isAdmin()) {
            return $query->where('user_id', Auth::user()->id);
        }
        return $query;
    }


    public function getPriceAttribute()
    {
        if (($this->attributes['price'] == null)) {
            return round(0.00);
        }
        return $this->attributes['price'];
    }


    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'bundle_formations');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfAuthor($query)
    {
        if (!\Auth::user()->isAdmin()) {
            return  $query->where('user_id', \Auth::user()->id);
        }
        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }


    public function students()
    {
        return $this->belongsToMany(User::class, 'bundle_student')->withTimestamps()->withPivot(['rating']);
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


    public function item()
    {
        return $this->morphMany(OrderItem::class, 'item');
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
}
