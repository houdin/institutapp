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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::factory(10)->create();

    }
}
