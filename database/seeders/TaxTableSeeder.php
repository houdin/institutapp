<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Models\Tax', 10)->create();
        $taxes = \App\Library\Data\FetchJsonFile::open('taxes.json');
        foreach ($taxes as $tax)
        {
            \App\Models\Tax::create([
               'name' => $tax['name'],
               'description' => $tax['description'],
            //    'percent' => $tax['percent'],
               'rate' => $tax['percent']
            ]);
        }
    }
}
