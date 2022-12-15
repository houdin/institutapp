<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'point_of_contact',
        'email'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTimestamps();
    }

    /**
     * Return the related projects for a given client
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}
