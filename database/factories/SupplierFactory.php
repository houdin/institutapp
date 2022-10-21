<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = $this->faker->company;
        return [
            'company' => $company,
            'slug' => Str::slug($company),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'title' => $this->faker->jobTitle                ,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'url' => $this->faker->url,
            'customer_id' => Str::random(10),
            'active' => Arr::random([0,1]),
            'status' => Arr::random([0,1]),
            'payment_methods' => $this->faker->creditCardType


        ];
    }
}
