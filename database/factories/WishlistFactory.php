<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wishlist;
use Faker\Generator as Faker;

$autoIncrement = 0;

$factory->define(Wishlist::class, function (Faker $faker) use ($autoIncrement) {
    $autoIncrement = $autoIncrement + 1;
    return [
        'user_id' => $autoIncrement
    ];
});
