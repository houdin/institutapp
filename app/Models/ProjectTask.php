<?php

namespace App\Models;

use App\Models\Project;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTask extends Model
{
    use SoftDeletes;
    protected $table = 'projects_tasks';


    protected $fillable = [
        'project_id', 'description', 'due_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // public function getSearchResult(): SearchResult
    // {
    //     return new SearchResult(
    //         $this,
    //         $this->description,
    //         '/project/' . $this->project_id
    //     );
    // }
}
