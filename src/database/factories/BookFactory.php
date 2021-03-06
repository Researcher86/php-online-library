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

$factory->define(App\Models\Book\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'annotation' => $faker->text,
        'page_count' => $faker->numberBetween(),
        'file' => str_random(255),
    ];
});
