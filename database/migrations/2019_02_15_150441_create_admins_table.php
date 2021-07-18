<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 60)->default("- - - - -");
            $table->string('last_name', 60)->default("- - - - -");
            $table->string('mobile', 20)->default("- - - - - - - - - -");
            $table->string('email', 50)->unique()->default(NULL);
            $table->string('password', 250)->nullable(false);
            $table->string('profile_pic', 350)->default("https://i.imgur.com/IIES5AV.png");
            $table->boolean('status')->default(false);
            $table->string('role', 10)->default("editor")->nullable(false);
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
        Schema::dropIfExists('admins');
    }
}
