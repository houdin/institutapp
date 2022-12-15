<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'type',
        'hostname',
        'username',
        'password',
        'port'
    ];

    protected $hidden = ['created_at','updated_at'];
}
