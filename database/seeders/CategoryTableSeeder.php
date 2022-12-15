<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    protected $categories = [
        'Women',
        'Men',
        'Kids',
        'Shoes',
        'Exercise',
        'Watches'
    ];
    protected $icon = [
        'fab fa-accessible-icon',
        'fab fa-accusoft',
        'fas fa-address-book',
        'far fa-address-card',
        'fas fa-adjust',
        'fab fa-adn',
        'fab fa-adversal',
        'fab fa-affiliatetheme',
        'fab fa-algolia',
        'fas fa-allergies',
        'fab fa-amazon',
        'fab fa-amazon-pay',
        'fas fa-ambulance',

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $randArray = [null, 1, 2, 3, 4, 5, 10, 15, 32, 49, 54, 18, 7, 29, 43, 12, 36];

        Category::factory(50)->create()->each(function ($category) use ($randArray) {
            $category->parent_id = Arr::random($randArray);
            $category->save();
        });
    }
}
