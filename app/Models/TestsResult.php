<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestsResult extends Model
{
	use HasFactory, Notifiable;

    protected $fillable = ['test_id', 'user_id', 'test_result'];

    public function answers()
    {
        return $this->hasMany('App\Models\TestsResultsAnswer');
    }

    public function test(){
        return $this->belongsTo(Test::class);
    }
}
