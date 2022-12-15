<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class SolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = ucwords(fake()->sentence(rand(2, 5), true));
        return [

            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),

        ];
    }
}
