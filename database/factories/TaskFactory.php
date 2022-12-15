<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Service;
use App\Models\Solution;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $project = Project::all()->random();

        foreach ($project->solutions() as $service) {
        }

        $num = Solution::where('project_id', $project->id)->orderByRaw("RAND()")->first();
        $service_id =  $num->id ? $num->id : 0;

        $completed = rand(0, 1);
        $completed_date = null;
        if ($completed) {
            $completed_date = date('Y-m-d H:i:s');
        }

        return [
            'description'        =>  fake()->sentence(),
            'user_id'             =>    1,
            'solution_id'         =>    Solution::all()->random()->id,
            'due_date' => fake()->dateTimeBetween('-6 months', '+6 months'),
            'complete' => $completed,
            'completed_date' => $completed_date,
            'weight'            =>    rand(1, 10),
            'priority'            => 3,
        ];
    }
}
