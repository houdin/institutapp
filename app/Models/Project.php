<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Upload;
use App\Models\Credential;
use App\Models\Projectuser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'description',
        'production',
        'complete',
        'completed_date',
        'stage',
        'dev',
        'github'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function credentials()
    {
        return $this->hasMany(Credential::class, 'project_id');
    }

    public function solutions()
    {
        return $this->belongsToMany(Solution::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'project_id');
    }

    /**
     * Checks if teh currently Auth user
     * is the owner of the project.
     *
     * @return bool
     */
    public function isOwner()
    {
        if ($this->user_id != Auth::id()) {
            return false;
        }

        return true;
    }


    /**
     * Checks if the current Auth user
     * is a member of a given project.
     *
     * @return bool
     */
    public function isMember()
    {

        $s = Projectuser::whereProjectId($this->id)->whereUserId(Auth::id())->get();
        if (count($s) == 0) {
            return false;
        }

        return true;
    }

    // Get the toal weight of the given project
    public function totalWeight()
    {
        return $this->tasks()->where('state', '!=', 'complete')->sum('weight');
    }
}
