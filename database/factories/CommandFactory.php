<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;

use App\Command;
use Faker\Generator as Faker;

$factory->define(Command::class, function (Faker $faker) {
    return [
       
        'fournisseur_id'=>$faker->randomDigit(1,10),
        'article_id'=>$faker->randomDigit(1,10),
        'qnt'=>$faker->randomDigit(1,122),

    ];
});
