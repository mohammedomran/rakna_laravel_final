<?php

use Illuminate\Database\Seeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\ColorTableSeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\AddressTableSeeder;
use Database\Seeders\WishlistTableSeeder;
use Database\Seeders\ProductTableSeeder;
use Database\Seeders\BranchimageTableSeeder;
use Database\Seeders\ColorProductTableSeeder;
use Database\Seeders\WishlistProductTableSeeder;
use Database\Seeders\ReviewTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ColorTableSeeder::class,
            CategoryTableSeeder::class,
            UserTableSeeder::class,
            AddressTableSeeder::class,
            WishlistTableSeeder::class,
            ProductTableSeeder::class,
            BranchimageTableSeeder::class,
            ColorProductTableSeeder::class,
            WishlistProductTableSeeder::class,
            ReviewTableSeeder::class
        ]);
    }
}
