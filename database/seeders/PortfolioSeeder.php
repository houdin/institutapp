<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Image;
use App\Models\Category;
use App\Models\Formation;
use App\Models\Portfolio;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Http\Traits\FileUploadTrait;

class PortfolioSeeder extends Seeder
{
    use FileUploadTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Portfolio::factory(20)->create()->each(function ($portfolio) {

            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $tags = Tag::inRandomOrder()->take(rand(1, 7))->pluck('id')->toArray();

            $portfolio->categories()->attach($categories);
            $portfolio->tags()->attach($tags);

            $name = 'portfolio_' . rand(1, 10) . '.jpg';

            $extension = 'jpg';

            $this->saveFileSeeder(public_path('images/portfolios/' . $name), $portfolio->title);

            // $head = head(explode('.', $this->placeholder[rand(0, 4)]));

            $file_name = Str::slug($portfolio->title);


            $image = Image::create([
                'name' => $name,
                'file_name' => $file_name,
                'url' => '/storage/uploads/images/' . date('Y/') . date('m/') . 'origin/' . $file_name . '.' . $extension,
                'extension' => $extension
            ]);

            $portfolio->image()->save($image);

            $portfolio->save();
        });

        // $formations = Formation::get()->take(3);

        // foreach ($formations as $formation) {
        //     $module_id = $formation->formationTimeline->where('sequence', '=', 1)->first()->model_id;
        //     $module = Module::find($module_id);
        //     $media = \App\Models\Media::where('type', '=', 'upload')
        //     ->where('model_type', '=', 'App\Models\Module')
        //     ->where('model_id', '=', $module->id)
        //     ->first();
        //     $filename = 'placeholder-video.mp4';
        //     $url = asset('storage/uploads/fmts/' . $filename);

        //     if ($media == null) {
        //         $media = new \App\Models\Media();
        //         $media->model_type = Module::class;
        //         $media->model_id = $module->id;
        //         $media->name = $filename;
        //         $media->url = $url;
        //         $media->type = 'upload';
        //         $media->file_name = $filename;
        //         $media->size = 0;
        //         $media->save();
        //     }

        //     $order = new \App\Models\Order();
        //     $order->user_id = 3;
        //     $order->reference_no = Str::random(8);
        //     $order->amount = $formation->price;
        //     $order->status = 1;
        //     $order->save();

        //     $order->items()->create([
        //         'item_id' => $formation->id,
        //         'item_type' => get_class($formation),
        //         'price' => $formation->price
        //     ]);
        //     generateInvoice($order);

        //     foreach ($order->items as $orderItem) {
        //         $orderItem->item->students()->attach(3);
        //     }
        // }
    }
}
