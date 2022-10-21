<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoProgress extends Model
{
	use HasFactory, Notifiable;
    //Relations
    public function user(){
        return $this->belongsTo(User::class);
    }


}
