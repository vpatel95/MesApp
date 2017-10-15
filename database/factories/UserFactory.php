<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\PersonalChat::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'user_id_1' => $faker->unique()->numberBetween($min=1, $max=100),
        'user_id_2' => $faker->unique()->numberBetween($min=101, $max=200),
    ];
});

$factory->define(App\GroupChat::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\GroupMember::class, function (Faker $faker) {

    return [
        'group_chat_id' => $faker->numberBetween($min=1, $max=10),
        'user_id' => $faker->unique()->numberBetween($min=1, $max=1000)
    ];
});

$factory->define(App\Chat::class, function (Faker $faker) {
    static $password;

    return [
        'type' => $faker->unique()->safeEmail,
        'c_id' => 'personal'
    ];
});

$factory->define(App\Message::class, function (Faker $faker) {
    static $password;

    return [
        'chat_id' => $faker->unique()->safeEmail,
        'user_id' => 
        'message' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});
