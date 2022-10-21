<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
	use HasFactory, Notifiable;
    protected  $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
