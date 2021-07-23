<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $which = $faker->randomFloat(2, 0, 1);
    if ($which < 0.5) {
        return [
            'category_id' => random_int(1, 12),
            'description' => $faker->text(1000),
            'name' => $faker->text(20),
            'main_image' => $faker->randomElement([
                "https://i.imgur.com/bn8Mp1O.jpg",
                "https://i.imgur.com/pTDTm0a.jpg",
                "https://i.imgur.com/kXc81gk.jpeg",
                "https://i.imgur.com/w0tX1rt.jpg",
                "https://i.imgur.com/dv1QgwX.jpeg",
                "https://i.imgur.com/VSU4xr7.jpeg",
                "https://i.imgur.com/JC89asT.jpeg",
                "https://i.imgur.com/0irAxHr.jpeg",
                "https://i.imgur.com/cNEgbj5.jpeg",
                "https://i.imgur.com/MHETaJO.jpeg"
            ]),
            'price' => $faker->randomFloat(2, 1000, 5000),
            'price_discount' => $faker->randomFloat(2, 150, 1500),
            'percentage_discount' => 0
        ];
    } else {
        return [
            'category_id' => random_int(1, 10),
            'description' => $faker->text(1000),
            'name' => $faker->text(20),
            'main_image' => $faker->randomElement([
                "https://i.imgur.com/bn8Mp1O.jpg",
                "https://i.imgur.com/pTDTm0a.jpg",
                "https://i.imgur.com/kXc81gk.jpeg",
                "https://i.imgur.com/w0tX1rt.jpg",
                "https://i.imgur.com/dv1QgwX.jpeg",
                "https://i.imgur.com/VSU4xr7.jpeg",
                "https://i.imgur.com/JC89asT.jpeg",
                "https://i.imgur.com/0irAxHr.jpeg",
                "https://i.imgur.com/cNEgbj5.jpeg",
                "https://i.imgur.com/MHETaJO.jpeg"
            ]),
            'price' => $faker->randomFloat(2, 1000, 5000),
            'price_discount' => 0,
            'percentage_discount' => $faker->randomFloat(2, 0, 100)
        ];
    }
});
