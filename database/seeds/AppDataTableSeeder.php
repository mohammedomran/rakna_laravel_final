<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppDataTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_data')->insert([
            'item' => 'app_version',
            'value' => '1.0.0'
        ]);

        DB::table('app_data')->insert([
            'item' => 'app_language',
            'value' => 'ar'
        ]);

        DB::table('app_data')->insert([
            'item' => 'mobile_app_link',
            'value' => 'www.example.com'
        ]);

        DB::table('app_data')->insert([
            'item' => 'taxes',
            'value' => '2'
        ]);

        DB::table('app_data')->insert([
            'item' => 'delivery',
            'value' => '0'
        ]);

        DB::table('app_data')->insert([
            'item' => 'shouldUpdate',
            'value' => '0'
        ]);
    }
}
