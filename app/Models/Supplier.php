<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;



    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }

    public function featured_image($num_size = null)
    {

        $date = $this->created_at->format('Y/m/');

        $extension = last(explode('.', $this->image->name));

        return $date . $this->image->file_name . '-' . get_image_size($num_size) . '.' . $extension;
    }
}
