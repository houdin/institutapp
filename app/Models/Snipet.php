<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Snipet extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function tipstricks()
    {
        return $this->belongsToMany(Tipstrick::class);
    }
}
