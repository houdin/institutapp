<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                 =>    fake()->company,
            'email'                =>    fake()->unique()->safeEmail,
            'description'       =>  fake()->paragraphs(rand(1, 2), true),
            'point_of_contact'     =>     fake()->name(),
            'phone_number'        =>    fake()->tollFreePhoneNumber(),
            'user_id'             =>     1,
        ];
    }
}
