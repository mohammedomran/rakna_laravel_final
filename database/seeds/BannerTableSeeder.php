<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            'image' => 'https://aldorahouse.s3-eu-west-1.amazonaws.com/assets/banners/1+(1).png'
        ]);

        DB::table('banners')->insert([
            'image' => 'https://aldorahouse.s3-eu-west-1.amazonaws.com/assets/banners/2.png'
        ]);

        DB::table('banners')->insert([
            'image' => 'https://aldorahouse.s3-eu-west-1.amazonaws.com/assets/banners/3.png'
        ]);

        DB::table('banners')->insert([
            'image' => 'https://aldorahouse.s3-eu-west-1.amazonaws.com/assets/banners/2.png'
        ]);
    }
}
