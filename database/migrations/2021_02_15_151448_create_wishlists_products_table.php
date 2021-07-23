<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlists_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wishlist_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('wishlist_id')->references('id')->on('wishlists');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('wishlists_products');
    }
}
