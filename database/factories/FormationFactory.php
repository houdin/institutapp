<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Formation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {




        $name = $this->faker->sentence(5);

        $price = rand(0, 1) ? $this->faker->randomFloat(2, 0, 199) : 0;

        return [
            'title' => $name,
            'category_id' => rand(1, 10),
            'slug' => Str::slug($name),
            // 'image_id' => $placeholder[rand(0, 2)],
            'description' => $this->faker->text(),
            'price' => $price,
            'free' => !$price ? 1 : 0,
            'featured' => Arr::random([0, 1]),
            'trending' => Arr::random([0, 1]),
            'popular' => Arr::random([0, 1]),
            'published' => 1,
        ];
    }
}
