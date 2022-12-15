<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaxItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Models\Tax', 10)->create();
        $taxes = \App\Models\Tax::all();
        // $taxes = \App\Models\Tax::inRandomOrder()->first();
        foreach ($taxes as $taxe) {
            $product = \App\Models\Product::inRandomOrder()->first();
            $formation = \App\Models\Formation::inRandomOrder()->first();

            $model = array($product, $formation);
            $key = array_rand($model);
            $model = $model[$key];

            $user = \App\Models\Auth\User::inRandomOrder()->first();

            \App\Models\TaxItem::create([
                'tax_id' => $taxe->id,
                'item_type' => get_class($model),
                'item_id' => $model->id,
                // 'user_id' => $user->id,
            ]);
        }
    }
}
