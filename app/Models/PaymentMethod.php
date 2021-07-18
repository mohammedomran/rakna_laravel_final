<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    
    protected $table = "payment_methods";

    protected $fillable = ["id", "name", "icon"];

    protected $hidden = [];

    public function userpaymentmethod() {
        //
        return $this->hasMany('App\Models\UsersPaymentMethod', 'paymentmethod_id');
    }
    

}
