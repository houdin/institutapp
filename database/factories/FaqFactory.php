<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $question = $this->faker->sentence($nbWords = 6, $variableNbWords = true) . '?';
        $answer = $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true);
        return [
            'category_id' => rand(1, 6),
            'question' => $question,
            'answer' => $answer
        ];
    }
}