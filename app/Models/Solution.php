<?php

namespace App\Models;

use App\Models\Project;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Solution extends Model implements Searchable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',

    ];
    public $timestamps = false;

    public $searchableType = 'Solution';

    public function getSearchResult(): SearchResult
    {
        $url = route('solution.description', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
