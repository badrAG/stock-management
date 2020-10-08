<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    $title = $faker->sentence(rand(5,10));
 
    return [
        'name'=>$title

    ];
});
