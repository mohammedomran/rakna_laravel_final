<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistProductTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 300; $i++) {
            DB::table('wishlists_products')->insert([
                'wishlist_id' => random_int(1, 20),
                'product_id' => random_int(1, 100)
            ]);
        }
    }
}
