<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    /**
     * Get the teacher that owns earning.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the order that owns earning.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the formation that owns earning.
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
