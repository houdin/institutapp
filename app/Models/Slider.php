<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($slider) { // before delete() method call this
            $date = $slider->created_at->format('Y/m/');
            $extension = $slider->image->extension;
            $file_name = $slider->image->file_name . '.' . $extension;
            if ($slider->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name))) {
                    File::delete(public_path('/storage/uploads/images/' . $date . 'origin/' . $file_name));

                    for ($i = 1; $i <= 5; $i++) {
                        $size = get_image_size($i, true);
                        $filename = $file_name . '-' . $size[0] . 'w.' . $extension;
                        if (File::exists(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename))) {
                            File::delete(public_path('/storage/uploads/images/' . $date . 'resizing/' . $size[0] . '/' . $filename));
                        }
                    }
                }
            }
        });
    }

    public function featured_image($num_size = null)
    {

        $date = $this->created_at->format('Y/m/');

        $extension = last(explode('.', $this->image->name));

        return $date . $this->image->file_name . '-' . get_image_size($num_size) . '.' . $extension;
    }
}
