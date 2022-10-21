<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipstrick extends Model
{
    use HasFactory;

    const EXCERPT_LENGTH = 100;

        /**
     * performs a search if algolia is not used
     * comment out if algolia is used
     *
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->where('title', 'like', "%$query%");
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function snipets()
    {
        return $this->belongsToMany(Snipet::class);
    }

    public function excerpt()
    {
        return Str::limit($this->description, self::EXCERPT_LENGTH) ;
    }

}
