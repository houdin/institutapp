<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "images";
    protected $guarded = [];

    protected $hidden = ['pivot'];


    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $path = Storage::path(Str::replace('/storage', 'public', $model->url));
            $colors = colorPalette($path);
            $model->colors = json_encode($colors);
        });
    }

    public function model()
    {
        return $this->morphTo();
    }


    public function delete()
    {

        $date = $this->created_at->format('Y/m/');
        $extension = $this->extension;
        $file_name = $this->file_name . '.' . $extension;
        if ($this->isForceDeleting()) {
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
        parent::delete();
    }

    public function colors(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),

        );
    }

    // public function featured_image($num_size = null)
    // {

    //     $date = $this->created_at->format('Y/m/');

    //     $extension = last(explode('.', $this->image->name));
    //     $name = head(explode('.', $this->image->name));

    //     $size = $num_size ? '-' . get_image_size($num_size) : '';

    //     return $date . $name . $size . '.' . $extension;
    // }

    public function featuredImageUrl($num_size)
    {

        $size = $num_size ? $this->get_image_size($num_size) : "";

        $url = str_replace("origin", "resizing/" . $size, $this->url);

        $url = str_replace($this->file_name, $this->file_name . "-" . $size . "w", $url);

        return $url;
    }

    public function get_image_size($num_size = null)
    {
        $size = "";
        switch ($num_size) {
            case 1:
                $size = "400";
                break;
            case 2:
                $size = "540";
                break;
            case 3:
                $size = "750";
                break;
            case 4:
                $size = "1350";
                break;
            case 5:
                $size = "1850";
        }

        return $size;
    }
}
// $year = date("Y");
// $month = date("m");
// $filename = "uploads/".$year;
// $filename2 = "uploads/".$year."/".$month;

// if(file_exists($filename)){
//     if(file_exists($filename2)==false){
//         mkdir($filename2,777, true);
//         }
// }else{
//     mkdir($filename, 777,true);
//         mkdir($filename2,777, true);
// }
