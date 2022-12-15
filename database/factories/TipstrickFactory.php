<?php

namespace Database\Factories;

use App\Models\Tipstrick;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipstrickFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tipstrick::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lang = ['php', 'javascript', 'vex', 'python'];
        $title = $this->faker->sentence(7);

        return [
            'title' => $title,
            'description' => $this->faker->text(600),
            'slug' => Str::slug($title),
            'language' => $lang[rand(0, 3)],
            'content' => $this->faker->text(1000),
            'published' => rand(0, 1),
        ];
    }
}
