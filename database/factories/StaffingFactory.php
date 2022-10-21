<?php

namespace Database\Factories;

use App\Models\Staffing;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staffing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(7);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'poste' => $this->faker->jobTitle,
            'role' => $this->faker->sentence(9),
            'periode' => 'Full-time',
            'contract' => 'Stage',
            // 'image_id' => $placeholder[rand(0, 2)],
            'content' => $this->faker->text(1000),
            'location' => $this->faker->streetAddress,
            'published' => Arr::random([0, 1]),
        ];
    }
}
