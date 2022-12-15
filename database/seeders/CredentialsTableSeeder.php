<?php

namespace Database\Seeders;

use App\Models\Credential;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CredentialsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Credential::create([]);
        }
    }
}
