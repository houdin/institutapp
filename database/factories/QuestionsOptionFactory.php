<?php

namespace Database\Factories;

use App\Models\QuestionsOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionsOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionsOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'option_text' => $this->faker->text(50) . '?',
            'correct' => rand(0, 1),
        ];
    }
}
