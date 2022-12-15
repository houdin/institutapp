<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IssueNote extends Model implements Searchable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'issues_notes';

    protected $fillable = [
        'issue_id', 'description'
    ];

    public function issue()
    {
        return $this->belongsTo('App\Models\Issue');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->description,
            '/issues/' . $this->issue_id
        );
    }
}
