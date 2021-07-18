<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersPaymentMethod;
use App\Models\PaymentMethod;
use App\Models\Complaint;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class UsersPaymentMethodsController extends Controller
{
    //
    use GeneralTrait;

    


    public function store(Request $request)
    {
        $user = User::find(Auth::guard('user-api')->user()->id);
        $user_id = $user->id;

        //UsersPaymentMethod::with('payment_method')->where('user_id', $user->id)->get();
        $validator = Validator::make($request->all(), [
            'owner' => 'required|string|max:100',
            'number' => 'required|string|max:25',
            'cvv' => 'required|string|max:5',
            'expire-year' => 'required|string',
            'expire-month' => 'required|string',
            'payment_method_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $user_payment_method = UsersPaymentMethod::create([
            'user_id' => $user_id,
            'owner' => $request->get('owner'),
            'number' => $request->get('number'),
            'cvv' => $request->get('cvv'),
            'expire-year' => $request->get('expire-year'),
            'expire-month' => $request->get('expire-month'),
            'paymentmethod_id' => $request->get('payment_method_id'),
        ]);
        
        return $this->returnData("user payment method has been stored successfully", "user_payment_method", $user_payment_method);
    }

    
    public function makePrimary(Request $request) {

        $validator = Validator::make($request->all(), [
            'user_payment_method_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        //make all isprimary fields be zeros
        $user = User::find(Auth::guard('user-api')->user()->id);
        $user_methods = UsersPaymentMethod::where('user_id', $user->id)->get();
        foreach($user_methods as $method){
            $method->update([
                'is_primary' => 0,
            ]);
        }

        $user_payment_method = UsersPaymentMethod::find($request->get("user_payment_method_id"));
        $user_payment_method->update([
            'is_primary' => 1,
        ]);

        $user_payment_methods = (object) array();
        $user_payment_methods->methods = UsersPaymentMethod::with('paymentmethod')->where('user_id', $user->id)->get();

        return $this->returnData("user payment methods has been changed successfully", "user_payment_methods", $user_payment_methods);
    
    }


    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_payment_method_id' => 'required',
        ]);

        $user_payment_methods = UsersPaymentMethod::find($request->user_payment_method_id);

        $user_payment_methods->delete();

        return $this->returnData("user payment methods has been deleted successfully", "user_payment_methods", "deleted");
    }

}
