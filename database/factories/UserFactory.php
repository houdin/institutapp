<?php

namespace Database\Factories;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        	'uuid' => Uuid::generate(4)->string,
            // 'name' => $this->faker->text(8),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
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
        });
    }
	public function inactive()
    {
    	return $this->state([
	            'inactive' => 0,
        });
    }
	public function confirmed()
    {
    	return $this->state([
	            'confirmed' => 1,
        });
    }
	public function unconfirmed()
    {
    	return $this->state([
	            'unconfirmed' => 0,
        });
    }
	public function softDelete()
    {
    	return $this->state([
	            'deleted_at' => \Illuminate\Support\Carbon::now(),
        });
    }
}
