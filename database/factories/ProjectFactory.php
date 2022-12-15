<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $completed = rand(0, 1);
        $completed_date = null;
        if ($completed) {
            $completed_date = date('Y-m-d H:i:s');
        }
        return [
            'user_id' => 1,
            'name' => ucwords(fake()->sentence(rand(3, 6), true)),
            'description' => fake()->sentence(),
            'due_date' => fake()->dateTimeBetween('-6 months', '+6 months'),
            'complete' => $completed,
            'completed_date' => $completed_date,
            'client_id' => Client::all()->random()->id
        ];
    }
}
