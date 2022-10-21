<?php

namespace App\Http\Traits;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{

    protected $now_year;

    protected $now_month;

    public function __construct()
    {
        $this->now_year = date('/Y');
        $this->now_month = date('/m');
    }
    /**
     * Create an UploadedFile object from absolute path
     *
     * @param     string $path
     * @param     bool $test default true
     * @return    object(Illuminate\Http\UploadedFile)
     *
     */
    // public function pathToUploadedFile($path, $test = true)
    // {
    //     // $request->validate([
    //     //     'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
    //     // ]);
    //     $filesystem = new Filesystem;

    //     $name = $filesystem->name($path);
    //     $extension = $filesystem->extension($path);
    //     $originalName = $name . '.' . $extension;
    //     $mimeType = $filesystem->mimeType($path);
    //     $error = null;

    //     return new UploadedFile($path, $originalName, $mimeType, $error, $test);
    // }
    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFileSeeder($imageSeed, $title)
    {

        ini_set('memory_limit', '-1');

        make_storage_dir();

        // mkdir(public_path('storage/uploads/thumb'), 0777);
        $catch_name = last(explode('/', $imageSeed));

        $extension = last(explode('.', $catch_name));
        $name = head(explode('.', $catch_name));
        $filename = Str::slug($title);
        // $file = $this->pathToUploadedFile($imageSeed);
        $image = Image::make($imageSeed);
        if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing'))) {
            mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing'), 0777, true);
        }
        if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/origin'))) {
            mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/origin'), 0777, true);
        }

        for ($i = 1; $i <= 5; $i++) {
            $size = get_image_size($i, true);
            $file_name = $filename . '-' . $size[0] . 'w.' . $extension;

            if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing/' . $size[0]))) {
                mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing/' . $size[0]), 0777, true);
            }

            Image::make($imageSeed)->fit($size[0], $size[1])->save(public_path('storage/uploads/images' . $this->now_year . $this->now_month) . '/resizing/' . $size[0] . '/' . $file_name);
        }
        // Image::make($file)->resize(50, 50)->save(public_path('storage/uploads' . $now_year . $now_month) . '/' . $filename);

        $image->save(public_path('storage/uploads/images' . $this->now_year . $this->now_month) . '/origin/' . $filename . '.' . $extension);
    }

    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request)
    {

        ini_set('memory_limit', '-1');

        make_storage_dir();

        // mkdir(public_path('storage/uploads/thumb'), 0777);

        $finalRequest = $request;

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {

                if ($request->has($key . '_max_width') && $request->has($key . '_max_height')) {
                    // Check file width
                    $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                    $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                    $filename = Str::slug($name);
                    $file = $request->file($key);
                    $image = Image::make($file);
                    if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing'))) {
                        mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing'), 0777, true);
                    }
                    if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/ori'))) {
                        mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/ori'), 0777, true);
                    }

                    for ($i = 1; $i <= 5; $i++) {
                        $size = get_image_size($i, true);
                        $file_name = $filename . get_image_size($i) . '.' . $extension;

                        if (!file_exists(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing/' . $size[0]))) {
                            mkdir(public_path('storage/uploads/images' . $this->now_year . $this->now_month . '/resizing/' . $size[0]), 0777, true);
                        }

                        Image::make($file)->fit($size[0], $size[1])->save(public_path('storage/uploads/images' . $this->now_year . $this->now_month) . '/resizing/' . $size[0] . '/' . $file_name);
                    }
                    // Image::make($file)->resize(50, 50)->save(public_path('storage/uploads' . $now_year . $now_month) . '/' . $filename);

                    $width = $image->width();
                    $height = $image->height();
                    if ($width > $request->{$key . '_max_width'} && $height > $request->{$key . '_max_height'}) {
                        $image->resize($request->{$key . '_max_width'}, $request->{$key . '_max_height'});
                    } elseif ($width > $request->{$key . '_max_width'}) {
                        $image->resize($request->{$key . '_max_width'}, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($height > $request->{$key . '_max_width'}) {
                        $image->resize(null, $request->{$key . '_max_height'}, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $image->save(public_path('storage/uploads/images' . $this->now_year . $this->now_month) . '/' . $filename . '.' . $extension);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename . '.' . $extension]));
                } else {

                    $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                    $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                    $filename = Str::slug($name) . '.' . $extension;
                    $request->file($key)->move(public_path('storage/uploads/images' . $this->now_year . $this->now_month), $filename);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                }
            }
        }
        return $finalRequest;
    }


    public function saveAllFiles(Request $request, $downloadable_file_input = null, $model_type = null, $model = null)
    {


        make_storage_dir();

        $finalRequest = $request;

        foreach ($request->all() as $key => $value) {

            if ($request->hasFile($key)) {


                if ($key == $downloadable_file_input) {
                    foreach ($request->file($key) as $item) {
                        $extension = last(explode('.', $item->getClientOriginalName()));
                        $name = head(explode('.', $item->getClientOriginalName()));
                        $filename = Str::slug($name) . '.' . $extension;
                        $size = $item->getSize() / 1024;
                        $item->move(public_path('storage/uploads/medias' . $this->now_year . $this->now_month), $filename);
                        Media::create([
                            'model_type' => $model_type,
                            'model_id' => $model->id,
                            'name' => $filename,
                            'url' => asset('storage/uploads/medias' . $this->now_year . $this->now_month . '/' . $filename),
                            'type' => $item->getClientMimeType(),
                            'file_name' => $filename,
                            'size' => $size,
                        ]);
                    }
                    $finalRequest = $finalRequest = new Request($request->except($downloadable_file_input));
                } else {
                    if ($key != 'video_file') {
                        if ($key == 'add_pdf') {
                            $file = $request->file($key);

                            $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                            $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                            $filename = Str::slug($name) . '.' . $extension;

                            $size = $file->getSize() / 1024;
                            $file->move(public_path('storage/uploads/medias' . $this->now_year . $this->now_month), $filename);
                            Media::create([
                                'model_type' => $model_type,
                                'model_id' => $model->id,
                                'name' => $filename,
                                'url' => asset('storage/uploads/medias' . $this->now_year . $this->now_month . '/' . $filename),
                                'type' => 'module_pdf',
                                'file_name' => $filename,
                                'size' => $size,
                            ]);
                            $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                        } elseif ($key == 'add_audio') {
                            $file = $request->file($key);

                            $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                            $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                            $filename = Str::slug($name) . '.' . $extension;

                            $size = $file->getSize() / 1024;
                            $file->move(public_path('storage/uploads/medias' . $this->now_year . $this->now_month), $filename);
                            Media::create([
                                'model_type' => $model_type,
                                'model_id' => $model->id,
                                'name' => $filename,
                                'type' => 'module_audio',
                                'file_name' => $filename,
                                'url' => asset('storage/uploads/medias' . $this->now_year . $this->now_month . '/' . $filename),
                                'size' => $size,
                            ]);
                            $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                        } else {
                            $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                            $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                            $filename = time() . '-' . Str::slug($name) . '.' . $extension;

                            $request->file($key)->move(public_path('storage/uploads/medias' . $this->now_year . $this->now_month), $filename);
                            $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                            $model->module_image = $filename;
                            $model->save();
                        }
                    }
                }
            }
        }

        return $finalRequest;
    }

    public function saveLogos(Request $request)
    {
        if (!file_exists(public_path('storage/logos'))) {
            mkdir(public_path('storage/logos'), 0777);
        }
        $finalRequest = $request;

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $extension = last(explode('.', $request->file($key)->getClientOriginalName()));
                $name = head(explode('.', $request->file($key)->getClientOriginalName()));
                $filename = time() . '-' . Str::slug($name) . '.' . $extension;
                $request->file($key)->move(public_path('storage/logos'), $filename);
                $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
            }
        }

        return $finalRequest;
    }
}
