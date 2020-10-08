<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Demande;
use Faker\Generator as Faker;

$factory->define(Demande::class, function (Faker $faker) {
    return [
        'agent_id'=>$faker->randomDigit(1,10),
        'article_id'=>$faker->randomDigit(1,10),
        'qnt'=>$faker->randomDigit(1,122),

    ];
});
