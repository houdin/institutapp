<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\Image;
use App\Models\Module;
use App\Models\Category;
use App\Models\Formation;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Http\Traits\FileUploadTrait;
use App\Models\Tag;

class FormationSeeder extends Seeder
{
    use FileUploadTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $count = 30;

    public function run()
    {

        //Adding Categories
        // \App\Models\Category::factory(10)->create()->each(function ($cat) {
        //     $cat->blogs()->saveMany(\App\Models\Blog::factory(4)->create());

        // });


        //Creating Formation
        Formation::factory($this->count)->create()->each(function ($formation) {

            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();

            $tags = Tag::inRandomOrder()->take(rand(1, 7))->pluck('id')->toArray();

            $formation->categories()->attach($categories);

            $formation->tags()->attach($tags);

            $formation->teachers()->sync([2]);
            // dd($formation->id);
            $formation->modules()->saveMany(Module::factory(10)->create());

            $name = 'formation_' . rand(1, 6) . '.jpg';

            $extension = 'jpg';

            $this->saveFileSeeder(public_path('images/formations/' . $name), $formation->title);

            // $head = head(explode('.', $this->placeholder[rand(0, 4)]));

            $file_name = Str::slug($formation->title);


            $image = Image::create([
                'name' => $name,
                'file_name' => $file_name,
                'url' => '/storage/uploads/images/' . date('Y/') . date('m/') . 'origin/' . $file_name . '.' . $extension,
                'extension' => $extension
            ]);

            $formation->image()->save($image);

            $formation->save();

            foreach ($formation->modules()->where('published', '=', 1)->get() as $key => $module) {
                $key++;
                $timeline = new \App\Models\FormationTimeline();
                $timeline->formation_id = $formation->id;
                $timeline->model_id = $module->id;
                $timeline->model_type = Module::class;
                $timeline->sequence = $key;
                $timeline->save();
            };

            $formation->tests()->saveMany(Test::factory(2)->create());
            foreach ($formation->tests as $key => $test) {
                $key += 11;
                $timeline = new \App\Models\FormationTimeline();
                $timeline->formation_id = $formation->id;
                $timeline->model_id = $test->id;
                $timeline->model_type = Test::class;
                $timeline->sequence = $key;
                $timeline->save();
            };
        });

        $formations = Formation::get()->take(3);

        foreach ($formations as $formation) {
            $module_id = $formation->formationTimeline->where('sequence', '=', 1)->first()->model_id;
            $module = Module::find($module_id);
            $media = \App\Models\Media::where('type', '=', 'upload')
                ->where('model_type', '=', 'App\Models\Module')
                ->where('model_id', '=', $module->id)
                ->first();
            $filename = 'placeholder-video.mp4';
            $url = asset('storage/uploads/fmts/' . $filename);

            if ($media == null) {
                $media = new \App\Models\Media();
                $media->model_type = Module::class;
                $media->model_id = $module->id;
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
            $order->amount = $formation->price;
            $order->status = 1;
            $order->save();

            $order->items()->create([
                'item_id' => $formation->id,
                'item_type' => get_class($formation),
                'price' => $formation->price
            ]);
            generateInvoice($order);

            foreach ($order->items as $orderItem) {
                $orderItem->item->students()->attach(3);
            }
        }
    }
}
