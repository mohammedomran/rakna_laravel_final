<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('userpaymentmethod_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('userpaymentmethod_id')->references('id')->on('payment_methods');
            $table->string('owner', 100)->nullable(false);
            $table->string('number', 255)->nullable(false);
            $table->string('expire-year', 255)->nullable(false);
            $table->string('expire-month', 255)->nullable(false);
            $table->string('cvv', 255)->nullable(false);
            $table->boolean('is_primary')->default(false);
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
        Schema::dropIfExists('users_payment_methods');
    }
}
