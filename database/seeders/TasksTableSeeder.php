<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\Solution;
use Illuminate\Database\Seeder;



class TasksTableSeeder extends Seeder
{

    use \Database\Seeders\Traits\DisableForeignKeys;
    use \Database\Seeders\Traits\TruncateTable;

    public function run()
    {
        // $faker = Faker\Factory::create();

        $this->disableForeignKeys();

        $this->truncate('tasks');

        $project = Project::all()->random();

        foreach ($project->services() as $service) {
        }

        $num = Solution::where(
            'project_id',
            $project_id
        )->orderByRaw("RAND()")->first();
        $service_id =  $num->id ? $num->id : 0;

        $completed = rand(0, 1);
        $completed_date = null;
        if ($completed) {
            $completed_date = date('Y-m-d H:i:s');
        }


        Task::factory()->create([
            'description'        =>  fake()->sentence(),
            'user_id'             =>    1,
            'service_id'         =>    Solution::all()->random()->id,
            'due_date' => fake()->dateTimeBetween('-6 months', '+6 months'),
            'complete' => $completed,
            'completed_date' => $completed_date,
            'weight'            =>    rand(1, 10),
            'priority'          => rand(1, 5),
        ]);

        $this->enableForeignKeys();
    }
}
