<?php

namespace Database\Seeders;

use App\Models\Blog;
use Faker\Generator;
use App\Models\Product;
use App\Models\Tutorial;
use App\Models\Formation;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class ReviewTableSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        // factory('App\Models\Review', 150)->create();
        // $reviews = \App\Library\Data\FetchJsonFile::open('reviews.json');

        $modelsCount = Product::count() + Formation::count() + Tutorial::count() + Blog::count();
        $modelsCount *= 3;

        for ($i = 1; $i < $modelsCount; $i++) {
            $product = \App\Models\Product::inRandomOrder()->first();
            $formation = \App\Models\Formation::inRandomOrder()->first();
            $tutorial = \App\Models\Tutorial::inRandomOrder()->first();
            $blog = \App\Models\Blog::inRandomOrder()->first();

            $model = array($product, $formation, $tutorial, $blog);
            $key = array_rand($model);
            $model = $model[$key];

            $user = \App\Models\Auth\User::inRandomOrder()->first();
            // dd($model);
            $model->reviews()->create(
                [
                    'user_id' => $user->id,
                    'rating' => rand(1, 5),
                    'content' => $faker->text(300)
                ]

            );
        }

        // foreach ($reviews as $review) {
        //     $product = \App\Models\Product::inRandomOrder()->first();
        //     $formation = \App\Models\Formation::inRandomOrder()->first();
        //     $tutorial = \App\Models\Tutorial::inRandomOrder()->first();
        //     $blog = \App\Models\Blog::inRandomOrder()->first();

        //     $model = array($product, $formation);
        //     $key = array_rand($model);
        //     $model = $model[$key];




        //     $user = \App\Models\Auth\User::inRandomOrder()->first();
        //     // dd($model);
        //     $model->review->saveMany(
        //         [
        //             'user_id' => $user->id,
        //             'rating' => rand(1, 5),
        //             'content' => $this->faker->text(300)
        //         ]

        //     );
        //     \App\Models\Review::create([

        //         'user_id' => $user->id,
        //         'content' => $this->faker->text(300)
        //     ]);
        // }
    }
}
