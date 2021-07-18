<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    
    protected $table = "transactions";

    protected $fillable = ["id", "order_id", "orderId", "authToken", "paymentToken", "transactionId", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function order() {
        //
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

}
