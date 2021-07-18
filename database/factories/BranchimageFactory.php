<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branchimage;
use Faker\Generator as Faker;

$factory->define(Branchimage::class, function (Faker $faker) {
    return [
        'product_id' => random_int(1, 100),
        'image' => $faker->randomElement([
            "https://i.imgur.com/ydCoIRE.jpeg",
            "https://i.imgur.com/2SApBNC.jpeg",
            "https://i.imgur.com/f7X0W8w.jpeg",
            "https://i.imgur.com/ymyUd4m.jpeg",
            "https://i.imgur.com/ZuNSxi9.jpeg",
            "https://i.imgur.com/D0L720L.jpg",
            "https://i.imgur.com/A8D9KZE.jpg",
            "https://i.imgur.com/V3BSgdX.jpeg",
            "https://i.imgur.com/zO2zdmq.jpg",
            "https://i.imgur.com/AIpbKAq.jpg"
        ])
    ];
});
