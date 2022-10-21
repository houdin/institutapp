<?php

namespace Database\Seeders;

use App\Http\Traits\FileUploadTrait;
use App\Models\Test;
use App\Models\Tutorial;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Image;

class TutorialSeeder extends Seeder
{
    use FileUploadTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        //Creating Tutorial
        Tutorial::factory(30)->create()->each(function ($tutorial) {

            $tutorial->teachers()->sync([2]);
            // dd($tutorial->id);

            $name = 'tutorial_' . rand(1, 5) . '.jpg';

            $extension = 'jpg';

            $this->saveFileSeeder(public_path('images/tutorials/' . $name), $tutorial->title);

            // $head = head(explode('.', $this->placeholder[rand(0, 4)]));

            $file_name = Str::slug($tutorial->title);


            $image = Image::create([
                'name' => $name,
                'file_name' => $file_name,
                'url' => '/storage/uploads/images/' . date('Y/') . date('m/') . 'origin/' . $file_name . '.' . $extension,
                'extension' => $extension
            ]);
            $tutorial->image()->save($image);
            $tutorial->save();
        });

        $tutorials = Tutorial::get()->take(3);

        foreach ($tutorials as $tutorial) {

            $media = \App\Models\Media::where('type', '=', 'upload')
                ->where('model_type', '=', 'App\Models\Tutorial')
                ->where('model_id', '=', $tutorial->id)
                ->first();
            $filename = 'placeholder-video.mp4';
            $url = asset('storage/uploads/tols/' . $filename);

            if ($media == null) {
                $media = new \App\Models\Media();
                $media->model_type = Tutorial::class;
                $media->model_id = $tutorial->id;
                $media->name = $filename;
                $media->url = $url;
                $media->type = 'upload';
                $media->file_name = $filename;
                $media->size = 0;
                $media->save();
            }

            $order = new \App\Models\Order();
            $order->user_id = 3;
            $order->reference_no = Str::random(8);
            $order->amount = $tutorial->price;
            $order->status = 1;
            $order->save();

            $order->items()->create([
                'item_id' => $tutorial->id,
                'item_type' => get_class($tutorial),
                'price' => $tutorial->price
            ]);
            // generateInvoice($order);

            foreach ($order->items as $orderItem) {
                $orderItem->item->students()->attach(3);
            }
        }
    }
}
