<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormationTimeline extends Model
{
	use HasFactory, Notifiable;
    protected $table = "formation_timeline";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

    public function formation(){
        return $this->belongsTo(Formation::class);
    }




}
