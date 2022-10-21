<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
	use HasFactory, Notifiable;
    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function tutorials()
    {
        return $this->morphedByMany(Tutorial::class, 'taggable');
    }

    public function formations()
    {
        return $this->morphedByMany(Formation::class, 'taggable');
    }

    public function tipstricks()
    {
        return $this->morphedByMany(Tipstrick::class, 'taggable');
    }

    public function portfolios()
    {
        return $this->morphedByMany(Portfolio::class, 'taggable');
    }

}
