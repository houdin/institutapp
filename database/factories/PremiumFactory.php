<?php

namespace Database\Factories;

use App\Models\Premium;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PremiumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Premium::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstNameMale;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            // 'image_id' => $placeholder[rand(0, 2)],
            'content' => $this->faker->sentences(7, true),
            'price' => $this->faker->randomFloat(2, 0, 199),

            'periodicity' => 3,
            'published' => 1


        ];
    }
}
