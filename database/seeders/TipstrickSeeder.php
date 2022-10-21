<?php

namespace Database\Seeders;

use App\Models\Snipet;
use App\Models\Tipstrick;
use Illuminate\Database\Seeder;

class TipstrickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Tipstrick::factory(30)->create()->each( function( $tipstrick) {

            $snipets = Snipet::factory(rand(1, 4))->create();

            $snipets = $snipets->pluck('id')->toArray();

            $tipstrick->snipets()->sync( $snipets );

        });
    }
}
