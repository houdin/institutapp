<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdraw extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    /**
     * Get the teacher profile that owns the user.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
