<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => random_int(1, 20),
        'product_id' => random_int(1, 100),
        'stars' => $faker->randomElement([1, 2, 3, 4, 5]),
        'review' => $faker->text(250)
    ];
});
