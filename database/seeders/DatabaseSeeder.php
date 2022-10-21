<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use Traits\TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'jobs',
            'sessions',
        ]);

        $this->call([
            LocaleSeeder::class,
            AuthTableSeeder::class,
            CategoryTableSeeder::class,
            TipstrickSeeder::class,
            PortfolioSeeder::class,
            PremiumSeeder::class,
            StaffingSeeder::class,
            BlogSeeder::class,
            SupplierSeeder::class,
            ProductTableSeeder::class,
            StateTableSeeder::class,
            PageSeeder::class,
            FormationSeeder::class,
            TutorialSeeder::class,
            QuestionsSeeder::class,
            ReviewTableSeeder::class,
            TaxTableSeeder::class,
            TaxItemsTableSeeder::class,
            ConfigSeeder::class,
            SliderSeeder::class,
            FaqSeeder::class,
            CommissionRateSeeder::class,
            TeacherProfileSeeder::class,
            ChatterTableSeeder::class
        ]);

        artisan::call('translations:import');
        artisan::call('storage:link');

        // Artisan::call('db:seed', [
        //     '--class' => 'translations:import',
        //     '--force' => true // <--- add this line
        // ]);
        // Artisan::call('db:seed', [
        //     '--class' => 'storage:link',
        //     '--force' => true // <--- add this line
        // ]);

        Model::reguard();
    }
}
