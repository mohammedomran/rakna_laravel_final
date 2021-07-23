<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branchimage;

class BranchimageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Branchimage::class, 250)->create();
    }
}
