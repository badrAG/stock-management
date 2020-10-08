<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fournisseur;
use Faker\Generator as Faker;

$factory->define(Fournisseur::class, function (Faker $faker) {
    return [
        'nom' => $faker->name,
        'prenom' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'tele' => $faker->phoneNumber,
        'adresse'=>$faker->address
       
    ];
});
