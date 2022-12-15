<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projectuser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'project_user';
}
