<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'name' => 'فيزا',
            'icon' => 'https://i.imgur.com/xA2iRfc.png'
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'ماستر كارد',
            'icon' => 'https://i.imgur.com/khMeWCO.png'
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'باى بال',
            'icon' => 'https://i.imgur.com/ln3lx59.png'
        ]);
    }
}
