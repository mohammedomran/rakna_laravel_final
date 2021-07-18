<?php

namespace App\Models;
use App\Models\Review;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    
    protected $table = "products";

    protected $fillable = ["id", "name", "category_id", "description", "price", "price_discount", "percentage_discount", "main_image", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];


    public function reviews() {
        //
        return $this->hasMany('App\Models\Review', 'product_id');

    }

    public function category() {
        //
        return $this->belongsTo('App\Models\Category', 'category_id');

    }

    public function orders() {
        //
        return $this->belongsToMany("App\Models\Order", "orders_products", "product_id", "order_id")->withPivot('quantity', 'color_id');
    }

    public function colors() {
        //
        return $this->belongsToMany("App\Models\Color", "colors_products", "product_id", "color_id");
    }

    
    public function branchimages() {
        //
        return $this->hasMany('App\Models\Branchimage', 'product_id');
    }
     

    public function wishlists() {
        //
        return $this->belongsToMany("App\Models\Wishlist", "wishlists_products", "product_id", "wishlist_id");
    }

}
