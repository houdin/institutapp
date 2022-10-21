<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(50);

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'content' => $this->faker->text(1000),
            'category_id' => rand(1,10),
            'user_id' => 1,
        ];
    }
}
