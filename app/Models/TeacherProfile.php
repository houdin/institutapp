<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherProfile extends Model
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'facebook_link', 'twitter_link', 'linkedin_link', 'payment_method', 'payment_details', 'description'
    ];

    /**
     * Get the teacher profile that owns the user.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
