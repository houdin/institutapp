<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Tutorial;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tutorial::class;

    protected $images = array('placeholder-1.jpg', 'placeholder-2.jpg', 'placeholder-3.jpg');
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {



        $name = $this->faker->sentence(5);

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            // 'image_id' => $placeholder[rand(0, 2)],
            'description' => $this->faker->text(),
            'content' => $this->faker->paragraphs(5, true),
            'price' => $this->faker->randomFloat(2, 0, 199),
            'time' => $this->faker->time(),
            'featured' => Arr::random([0, 1]),
            'trending' => Arr::random([0, 1]),
            'popular' => Arr::random([0, 1]),
            'published' => 1,
        ];
    }
}
