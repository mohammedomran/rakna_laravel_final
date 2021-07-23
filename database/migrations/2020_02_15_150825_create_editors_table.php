<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 60)->default("- - - - -");
            $table->string('last_name', 60)->default("- - - - -");
            $table->string('mobile', 25)->default("- - - - - - - - - -");
            $table->string('email', 50)->unique()->nullable(false);
            $table->string('profile_pic', 255)->default("https://i.imgur.com/IIES5AV.png");
            $table->string('password', 300)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editors');
    }
}
