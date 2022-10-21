<?php

namespace Database\Factories;

use App\Models\TeacherProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeacherProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $paymentDetails = '{"bank_name":"","ifsc_code":"","account_number":"","account_name":"","paypal_email":"adminteacher@demo.com"}';
        return [
            'user_id' => 2,
            'facebook_link' => $this->faker->url,
            'twitter_link' => $this->faker->url,
            'linkedin_link' => $this->faker->url,
            'payment_method' => 'paypal',
            'payment_details' => $paymentDetails
        ];
    }
}
