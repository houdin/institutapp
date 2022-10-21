<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Portfolio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(5);
        $placeholder = ['portfolio_1.jpg', 'portfolio_2.jpg', 'portfolio_3.jpg', 'portfolio_4.jpg', 'portfolio_5.jpg'];
        return [
            'title' => $name,
            'category_id' => rand(1, 10),
            'slug' => Str::slug($name),
            // 'image_id' => $placeholder[rand(0, 2)],
            'description' => $this->faker->text(),
            'meta_keywords' => $this->faker->words(3, true),
            'date' => $this->faker->dateTime(),

            'published' => Arr::random([0,1]),
        ];
    }
}
