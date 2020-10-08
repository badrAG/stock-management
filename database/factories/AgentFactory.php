<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Agent;
use Faker\Generator as Faker;

$factory->define(Agent::class, function (Faker $faker) {
    return [
        'nom' => $faker->name,
        'prenom' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'tele' => $faker->phoneNumber,
        'service_id'=>$faker->randomDigit(1,10),
       
    ];
});
