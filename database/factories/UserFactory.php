<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
