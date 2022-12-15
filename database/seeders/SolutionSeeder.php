<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Solution;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    use \Database\Seeders\Traits\DisableForeignKeys;
    use \Database\Seeders\Traits\TruncateTable;

    public function run()
    {

        $this->disableForeignKeys();

        $this->truncate('solutions');


        $name = "Effets Spéciaux";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "3D & Modélisation";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Motion & Design Graphics";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Animation";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "TV & Broadcast";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Storyboard";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Architecture";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Web & Applications";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);
        $name = "Marketing";
        Solution::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(1, true),
            'color' => fake()->hexColor(),
            'icon' => fake()->safeColorName(),
        ]);



        // Service::factory(70)->create()->each(function ($item) {
        //     $project = Project::all()->random();

        //     $project->services()->attach($item->id);
        // });

        $this->enableForeignKeys();
    }
}
