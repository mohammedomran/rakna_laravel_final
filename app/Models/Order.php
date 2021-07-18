<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    
    protected $table = "orders";

    protected $fillable = ["id", "user_id", "address_id", "userpaymentmethod_id", "status", "price", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function products() {
        //
        return $this->belongsToMany('App\Models\Product', 'orders_products', 'order_id', 'product_id')->withPivot('quantity', 'color_id');
    }

    public function address() {
        //
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function complaints() {
        //
        return $this->hasMany('App\Models\Complaint', 'order_id');
    }

    public function userpaymentmethod() {
        //
        return $this->belongsTo('App\Models\UsersPaymentMethod', 'userpaymentmethod_id');
    }

    public function transaction() {
        //
        return $this->hasOne('App\Models\Transaction', 'order_id');
    }
    

}
