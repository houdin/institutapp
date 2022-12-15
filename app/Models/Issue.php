<?php

namespace App\Models;


use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issue extends Model implements Searchable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description', 'priority', 'user_id', 'project_id'
    ];



    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany('App\Models\IssueNote');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->description,
            '/issues/' . $this->id
        );
    }

    public function uploads()
    {
        return $this->morphMany('App\Models\Upload', 'uploadable');
    }
}
