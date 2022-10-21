<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;
        $icon = [
            'fab fa-accessible-icon',
            'fab fa-accusoft' ,
            'fas fa-address-book' ,
            'far fa-address-card' ,
            'fas fa-adjust',
            'fab fa-adn',
            'fab fa-adversal',
            'fab fa-affiliatetheme' ,
            'fab fa-algolia' ,
            'fas fa-allergies',
            'fab fa-amazon',
            'fab fa-amazon-pay',
            'fas fa-ambulance',

        ];
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'status' => 1,
            'icon' => Arr::random($icon)
        ];
    }
}
