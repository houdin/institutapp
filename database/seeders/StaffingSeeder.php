<?php

namespace Database\Seeders;

use App\Models\Staffing;
use Illuminate\Database\Seeder;

class StaffingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staffing::factory(15)->create();
    }
}
