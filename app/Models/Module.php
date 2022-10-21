<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
//use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Support\Facades\File;
use Mtownsend\ReadTime\ReadTime;


/**
 * Class Module
 *
 * @package App
// * @property string $formation
 * @property string $title
 * @property string $slug
 * @property string $module_image
 * @property text $short_text
 * @property text $full_text
 * @property integer $position
 * @property string $downloadable_files
 * @property tinyInteger $free_module
 * @property tinyInteger $published
 */

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'module_image', 'short_text', 'full_text', 'position', 'downloadable_files', 'free_module', 'published', 'formation_id'];

    protected $appends = ['module_readtime', 'is_completed', 'get_class', 'read_time'];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($module) { // before delete() method call this
            if ($module->isForceDeleting()) {
                $media = $module->media;
                foreach ($media as $item) {
                    if (File::exists(public_path('/storage/uploads/medias/modules/' . $item->name))) {
                        File::delete(public_path('/storage/uploads/medias/modules/' . $item->name));
                    }
                }
                $module->media()->delete();
            }
        });
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setFormationIdAttribute($input)
    {
        $this->attributes['formation_id'] = $input ? $input : null;
    }

    // public function getImageAttribute()
    // {
    //     if ($this->attributes['module_image'] != NULL) {
    //         return url('storage/uploads/fmts/'.$this->module_image);
    //     }
    //     return NULL;
    // }
    public function image()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function getModuleReadtimeAttribute()
    {

        if ($this->full_text != null) {
            $readTime = (new ReadTime($this->full_text))->toArray();
            return $readTime['minutes'];
        }
        return 0;
    }

    public function moduleMediaAttribute()
    {
    }


    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPositionAttribute($input)
    {
        $this->attributes['position'] = $input ? $input : null;
    }


    public function readTime()
    {
        if ($this->full_text != null) {
            $readTime = (new ReadTime($this->full_text))->toArray();
            return $readTime['minutes'];
        }
        return 0;
    }

    public function getReadTimeAttribute()
    {
        return $this->readTime();
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function test()
    {
        return $this->hasOne('App\Models\Test');
    }

    public function students()
    {
        return $this->belongsToMany('App\Models\Auth\User', 'module_student')->withTimestamps();
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function chapterStudents()
    {
        return $this->morphMany(ChapterStudent::class, 'model');
    }

    public function downloadableMedia()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed', 'module_pdf', 'module_audio'];

        return $this->morphMany(Media::class, 'model')
            ->whereNotIn('type', $types);
    }


    public function mediaVideo()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed'];
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', $types);
    }

    public function mediaPDF()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('type', '=', 'module_pdf');
    }

    public function mediaAudio()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('type', '=', 'module_audio');
    }

    public function formationTimeline()
    {
        return $this->morphOne(FormationTimeline::class, 'model');
    }

    public function isCompleted()
    {
        $isCompleted = $this->chapterStudents()->where('user_id', \Auth::id())->count();
        if ($isCompleted > 0) {
            return true;
        }
        return false;
    }

    public function getIsCompletedAttribute()
    {
        return $this->isCompleted();
    }

    public function getGetClassAttribute()
    {

        return get_class($this);
    }
}
