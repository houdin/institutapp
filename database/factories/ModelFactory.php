<?php

namespace Database\Factories;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Auth\User::class, function (Faker\Generator $this->faker) {
    static $password;

    return [
        // 'username' => $this->faker->userName,
        'email' => $this->faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'phone' => $this->faker->phoneNumber,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function(Faker\Generator $this->faker){
    return [
        'name' => $this->faker->name
    ];
});

// $factory->define(\App\Models\Auth\Role::class, function () {
//     return [
//         'name' => 'admin'
//     ];
// });


$factory->define(App\Models\Product::class, function(Faker\Generator $this->faker) {
    $categories = \App\Models\Category::all()->pluck('id');
    $image = \App\Models\Image::all()->pluck('id');
    $tax = \App\Models\Tax::all()->pluck('id');
    return [
        'title' => $this->faker->realText($maxNbChars = 10, $indexSize = 2),
        'category_id' => $this->faker->randomElement($categories->toArray()),
        'image_id' => $this->faker->randomElement($image->toArray()),
        'tax_id' => $this->faker->randomElement($tax->toArray()),
        'price' => $this->faker->randomNumber(2),
        'description' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
        'weight' => $this->faker->randomFloat(3, 0.1, 50)
    ];
});

$factory->define(App\Models\Review::class, function(Faker\Generator $this->faker) {
    $user = \App\Models\Auth\User::all()->pluck('id');
    $product = \App\Models\Product::all()->pluck('id');
    return [
        'user_id' => $this->faker->randomElement($user->toArray()),
        'product_id' =>  $this->faker->randomElement($product->toArray()),
        'stars' => rand(1, 5),
        'review' => $this->faker->paragraph
    ];
});

$factory->define(App\Models\Image::class, function() {
    return [
        'path' =>  'http://via.placeholder.com/400x300',
        'thumbnail' => 'http://via.placeholder.com/200x150'
    ];
});


$factory->define(App\Models\Address::class, function(Faker\Generator $this->faker) {
    $user = \App\Models\Auth\User::all()->pluck('id');
    $states = \App\Models\State::all()->pluck('id');

    return [
        'user_id' => $this->faker->randomElement($user->toArray()),
        'address' =>  $this->faker->streetAddress,
        'city' => $this->faker->city,
        'postal_code' => $this->faker->postcode,
        'state_id' => $this->faker->randomElement($states->toArray()),
    ];
});

$factory->define(App\Models\State::class, function(Faker\Generator $this->faker) {
    return [
        'name' =>  $this->faker->state,
        'abbreviation' => $this->faker->stateAbbr
    ];
});

$factory->define(App\Models\Order::class, function(Faker\Generator $this->faker) {
    $userIDs = \App\Models\Auth\User::has('addresses')->pluck('id')->toArray();
    $user = \App\Models\Auth\User::findOrFail($userIDs[array_rand($userIDs)]);
    $orderDate = $this->faker->date('Y-m-d H:i:s', 'now');
    $shipDate = new DateTime($orderDate);
    $shipDate->add(new DateInterval('P5D'));


    return [
        'user_id' => $user->id,
        'address_id' => $user->addresses()->first()->id,
        'order_date' => $orderDate,
        'ship_date' => $shipDate->format('Y-m-d H:i:s'),
        'total' => $this->faker->randomNumber(2),
        'sub_total' => $this->faker->randomNumber(2) * .9,
        'taxes' => 1.93
    ];
});

$factory->define(App\Models\Tax::class, function(Faker\Generator $this->faker) {
    return [
        'name' =>  $this->faker->word,
        'percent' => $this->faker->randomFloat(3, 0, .3),
        'description' => $this->faker->sentence
    ];
});

$factory->define(App\Models\Sale::class, function(Faker\Generator $this->faker) {
    $products = \App\Models\Product::all()->pluck('id');
    return [
        'product_id' => $this->faker->randomElement($products->toArray()),
        'start' => $this->faker->dateTimeBetween('-14 days', 'now'),
        'finish' => $this->faker->dateTimeBetween('now', '+14 days'),
        'discount' => $this->faker->randomElement($array = array(.1, .15, .2, .25, .3, .35, .40))
    ];
});
