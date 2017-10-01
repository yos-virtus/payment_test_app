<?php

use Faker\Generator as Faker;

$factory->define(App\UserTransaction::class, function(Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, 0, 10000.00),
        'created_at' => \Carbon\Carbon::now()
    ];
});
