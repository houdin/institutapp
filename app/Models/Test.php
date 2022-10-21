<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtownsend\ReadTime\ReadTime;

/**
 * Class Test
 *
 * @package App
 * @property string $formation
 * @property string $module
 * @property string $title
 * @property text $description
 * @property tinyInteger $published
 */

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'slug', 'published', 'formation_id', 'module_id'];


    protected static function boot()
    {
        parent::boot();
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('formation', function ($q) {
                        $q->whereHas('teachers', function ($t) {
                            $t->where('formation_user.user_id', '=', auth()->user()->id);
                        });
                    });
                });
            }
        }
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setFormationIdAttribute($input)
    {
        $this->attributes['formation_id'] = $input ? $input : null;
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setModuleIdAttribute($input)
    {
        $this->attributes['module_id'] = $input ? $input : null;
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id')->withTrashed();
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id')->withTrashed();
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_test')->withTrashed();
    }

    public function chapterStudents()
    {
        return $this->morphMany(ChapterStudent::class, 'model');
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
}
