<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Test;
use App\Models\Image;
use App\Models\Module;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Http\Traits\FileUploadTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogSeeder extends Seeder
{
    use FileUploadTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // protected $placeholder = ['blog_1.jpg', 'blog_2.jpg', 'blog_3.jpg', 'blog_4.jpg', 'blog_5.jpg'];


    public function run()
    {
        // $placeholder = ['blog_1.jpg', 'blog_2.jpg', 'blog_3.jpg', 'blog_4.jpg', 'blog_5.jpg'];

        // for ($i = 1; $i <= count($this->placeholder); $i++) {
        //     $this->saveFileSeeder(public_path('images/blogs/blog_' . $i . '.jpg'));
        // }

        //Creating Blog
        Blog::factory(35)->create()->each(function ($blog) {

            $category = Category::inRandomOrder()->first();

            $blog->category()->associate($category);



            // $file = new UploadedFile(
            //     '/absolute/path/to/file',
            //     'original-name.gif',
            //     'image/gif',
            //     1234,
            //     TRUE
            // );
            // dd($tutorial->id);


            $name = 'blog_' . rand(1, 17) . '.jpg';

            $extension = 'jpg';

            $this->saveFileSeeder(public_path('images/blogs/' . $name), $blog->title);

            // $head = head(explode('.', $this->placeholder[rand(0, 4)]));

            $file_name = Str::slug($blog->title);


            $image = Image::create([
                'name' => $name,
                'file_name' => $file_name,
                'url' => '/storage/uploads/images/' . date('Y/') . date('m/') . 'origin/' . $file_name . '.' . $extension,
                'extension' => $extension
            ]);


            $blog->save();

            $blog->image()->save($image);
        });
    }
}
