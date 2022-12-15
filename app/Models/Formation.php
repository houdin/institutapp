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
 * Class Formation
 *
 * @package App
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property decimal $price
 * @property string $formation_image
 * @property string $start_date
 * @property tinyInteger $published
 */

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Formation extends Model implements Searchable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = ['category_id', 'title', 'slug', 'description', 'price', 'image_id', 'formation_video', 'start_date', 'published', 'free', 'featured', 'trending', 'popular', 'meta_title', 'meta_description', 'meta_keywords'];

    // protected $hidden = ['image'];

    protected $appends = ['chapter_count', 'students_count', 'rating'];

    protected $hidden = ['pivot'];

    // protected $with = ['rating'];

    public $searchableType = 'Formation';


    protected static function boot()
    {
        parent::boot();
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('teachers', function ($q) {
                        $q->where('formation_user.user_id', '=', auth()->user()->id);
                    });
                });
            }
        }
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('formations.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    // static::deleting(function ($formation) { // before delete() method call this
    //     $date = $formation->created_at->format('Y/m/');
    //     $extension = $formation->image->extension;
    //     $file_name = $formation->image->file_name . '.' . $extension;
    //     if ($formation->isForceDeleting()) {
    //         if (File::exists(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name))) {
    //             File::delete(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name));

    //             for ($i = 1; $i <= 5; $i++) {
    //                 $size = get_image_size($i, true);
    //                 $filename = $file_name . '-' . $size[0] . 'w.' . $extension;
    //                 if (File::exists(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename))) {
    //                     File::delete(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename));
    //                 }
    //             }
    //         }
    //     }
    // });



    public function getImageNameAttribute()
    {
        if ($this->image) {
            return $this->image;
        }
        return NULL;
    }


    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }



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
        return $this->belongsToMany(User::class, 'formation_user')->withPivot('user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'formation_student')->withTimestamps()->withPivot(['rating']);
    }

    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('position');
    }

    public function publishedModules()
    {
        return $this->hasMany(Module::class)->where('published', 1);
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
        return $this->hasMany('App\Models\Test');
    }

    public function formationTimeline()
    {
        return $this->hasMany(FormationTimeline::class);
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

    public function progress()
    {
        $main_chapter_timeline = $this->modules()->pluck('id')->merge($this->tests()->pluck('id'));

        $completed_modules = auth()->user()->chapters()->where('formation_id', $this->id)->pluck('model_id');
        if ($completed_modules->count() > 0) {
            return intval($completed_modules->count() / $main_chapter_timeline->count() * 100);
        } else {
            return 0;
        }
    }

    public function isUserCertified()
    {
        $status = false;
        $certified = auth()->user()->certificates()->where('formation_id', '=', $this->id)->first();
        if ($certified != null) {
            $status = true;
        }
        return $status;
    }

    public function item()
    {
        return $this->morphMany(OrderItem::class, 'item');
    }


    public function chapterCount()
    {
        $timeline = $this->formationTimeline;
        $chapters = 0;
        foreach ($timeline as $item) {
            if (isset($item->model) && ($item->model->published == 1)) {
                $chapters++;
            }
        }
        return $chapters;
    }

    public function getChapterCountAttribute()
    {
        return $this->chapterCount();
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
        return $this->where('title', 'like', "%$query%")->orWhere('description', 'like', "%$query%");
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function delete()
    {
        $this->image()->delete(); // DELETE * FROM files WHERE user_id = ? query

        parent::delete();
    }

    public function restore()
    {
        $this->image()->restore(); // DELETE * FROM files WHERE user_id = ? query

        parent::restore();
    }
}
