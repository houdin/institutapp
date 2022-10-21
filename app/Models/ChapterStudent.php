<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ChapterStudent extends Model
{
	use HasFactory, Notifiable;
    protected $table = "chapter_students";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

}
