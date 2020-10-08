<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Marque;
use Faker\Generator as Faker;

$factory->define(Marque::class, function (Faker $faker) {
    $title = $faker->sentence(rand(5,8));
   
    return [
        'name'=>$title
    ];
});
