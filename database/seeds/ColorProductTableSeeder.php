<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorProductTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            DB::table('colors_products')->insert([
                'color_id' => random_int(1, 10),
                'product_id' => random_int(1, 100)
            ]);
        }
    }
}
