<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\Service;
use App\Models\Solution;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{


    use \Database\Seeders\Traits\DisableForeignKeys;
    use \Database\Seeders\Traits\TruncateTable;

    public function run()
    {

        $this->disableForeignKeys();




        Project::factory(50)->create()->each(function ($project) {
            $solutions = Solution::all()->random(6);

            $counter = 0;
            $num = rand(2, 6);
            foreach ($solutions as $solution) {

                if ($counter == $num) break;
                // dd($solutions);

                $solution->projects()->attach($project->id);


                foreach (range(1, 10) as $index) {
                    $completed = rand(0, 1);
                    $completed_date = null;
                    if ($completed) {
                        $completed_date = date('Y-m-d H:i:s');
                    }
                    Task::create([
                        'description'        =>  fake()->sentence(),
                        'user_id'             =>    1,
                        'project_id'         =>    $project->id,
                        'solution_id'         =>    $solution->id,
                        'due_date' => fake()->dateTimeBetween('-6 months', '+6 months'),
                        'complete' => $completed,
                        'completed_date' => $completed_date,
                        'weight'            =>    rand(1, 10),
                        'priority'          => rand(1, 5),
                    ]);
                }
                $counter++;
            }
        });



        $this->enableForeignKeys();
    }
}
