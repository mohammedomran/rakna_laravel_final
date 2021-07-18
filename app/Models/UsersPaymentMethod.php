<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersPaymentMethod extends Model
{
    //
    
    protected $table = "users_payment_methods";

    protected $fillable = ["id", "user_id", "paymentmethod_id", "owner", "number", "expire-year", "expire-month", "cvv", "is_primary", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function paymentmethod() {
        //
        return $this->belongsTo('App\Models\PaymentMethod', 'paymentmethod_id');
    }

    public function orders() {
        //
        return $this->hasMany('App\Models\Order', 'userpaymentmethod_id');
    }

}
