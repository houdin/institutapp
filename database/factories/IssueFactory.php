<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $resolved = rand(0, 1);
        $resolved_date = null;
        if ($resolved) {
            $resolved_date = date('Y-m-d H:i:s');
        }
        $project = Project::all()->random();
        // $solutions = $project->solutions();
        // dd($solutions);
        $solution_id = $project->solutions()->get()->random()->id;

        return [
            'user_id' => $project->user_id,
            'client_id' => $project->client_id,
            'project_id' => $project->id,
            'solution_id' => $solution_id,
            'description' => fake()->paragraph(10),
            'priority' => rand(1, 5),
            'resolved' => $resolved,
            'resolved_date' => $resolved_date,
        ];
    }
}
