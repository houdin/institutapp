<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Support\Str;
use App\Models\Traits\Commentable;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Blog extends Model implements Searchable
{


    use HasFactory, Notifiable, Commentable;
    use SoftDeletes;

    // protected $appends = ['blog_author', 'comments_count'];

    const EXCERPT_LENGTH = 100;

    protected $hidden = ['pivot'];

    public $searchableType = 'Article';

    // protected $with = ['image', 'category', 'tags', 'comments'];

    public function getSearchResult(): SearchResult
    {
        $url = route('blogs.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }


    public function getBlogAuthorAttribute()
    {
        return $this->author->full_name;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($blog) {
            // before delete() method call this

            $date = $blog->created_at->format('Y/m/');
            if (File::exists(public_path('/storage/uploads/' . $date . $blog->image->name))) {
                File::delete(public_path('/storage/uploads/' . $date . $blog->image->name));
            }
            $extension = last(explode('.', $blog->image->name));
            for ($i = 1; $i <= 5; $i++) {
                $filename = $blog->image->file_name . '-' . get_image_size($i) . '.' . $extension;
                if (File::exists(public_path('/storage/uploads/' . $date . $filename))) {
                    File::delete(public_path('/storage/uploads/' . $date . $filename));
                }
            }
        });
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $table = 'blogs';

    protected $guarded = ['id'];

    // public function comments()
    // {
    //     return $this->morphMany(Comment::class, 'commentable');
    // }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_blog');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function excerpt()
    {
        return Str::limit($this->content, self::EXCERPT_LENGTH);
    }

    public function featured_image($num_size = null)
    {

        $date = $this->created_at->format('Y/m/');

        $extension = last(explode('.', $this->image->name));

        $size = $num_size ? '-' . get_image_size($num_size) : '';

        return $date . $this->image->file_name . $size . '.' . $extension;
    }

    public function featured_image_url($num_size = null)
    {

        $date = $this->created_at->format('Y/m/');

        $extension = last(explode('.', $this->image->name));

        $size = $num_size ? '-' . get_image_size($num_size) : '';

        $name_size = $this->image->file_name . $size;

        $url = str_replace($this->image->file_name, $this->image->file_name . $size, $this->image->url);

        return $url;
    }
}
