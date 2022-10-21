<?php

namespace Database\Seeders;

use App\Models\Premium;
use Illuminate\Database\Seeder;

class PremiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Premium::factory(3)->create();
    }
}
