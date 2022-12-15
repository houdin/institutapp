<?php

namespace Database\Factories\Auth;

use App\Models\Team;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'uuid' => Str::uuid(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '0000', // password
            'password_changed_at' => null,
            'remember_token' => Str::random(10),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'active' => 1,
            'confirmed' => 1,
        ];
    }

    public function active()
    {
        return $this->state([
            'active' => 1,
        ]);
    }
    public function inactive()
    {
        return $this->state([
            'inactive' => 0,
        ]);
    }
    public function confirmed()
    {
        return $this->state([
            'confirmed' => 1,
        ]);
    }
    public function unconfirmed()
    {
        return $this->state([
            'unconfirmed' => 0,
        ]);
    }
    public function softDelete()
    {
        return $this->state([
            'deleted_at' => \Illuminate\Support\Carbon::now(),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
