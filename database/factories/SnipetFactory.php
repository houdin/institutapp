<?php

namespace Database\Factories;

use App\Models\Snipet;
use Illuminate\Database\Eloquent\Factories\Factory;

class SnipetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Snipet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $lang = ['php', 'javascript', 'vex', 'python'];
        return [
            'title' => $this->faker->sentence(7),
            'language' => $lang[rand(0, 3)],
            'content' => $this->faker->text(300)
        ];
    }
}
