<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
   
        $title = $faker->sentence(rand(5,8));
        return [
            'name'=>$title,
            'slug'=> Str::slug($title),
            
           
    
        ];
   
});
