<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'weight',
        'user_id',
        'project_id',
        'complete',
        'completed_date',
        'priority',
        'description'
    ];

    protected  $hidden = [
        "created_at",
        "updated_at",
    ];

    /**
     * Relationship to project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
