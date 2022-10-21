<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snipet extends Model
{
    use HasFactory;


    public function tipstricks()
    {
        return $this->belongsToMany(Tipstrick::class);
    }
}
