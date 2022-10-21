<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class SeedImageTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::factory( 20)->create();
    }
}
