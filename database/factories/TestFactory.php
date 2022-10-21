<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(30);
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'description' => $this->faker->paragraph(10),
            'slug' => $slug,
            'published' => 1,
        ];
    }
}
