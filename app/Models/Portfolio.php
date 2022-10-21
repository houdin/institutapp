<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Portfolio extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($portfolio) { // before delete() method call this
            $date = $portfolio->created_at->format('Y/m/');
            $extension = $portfolio->image->extension;
            $file_name = $portfolio->image->file_name . '.' . $extension;
            if ($portfolio->isForceDeleting()) {
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

    public function category()
    {
        return $this->belongsTo(Category::class);
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
