<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UsersPaymentMethod;
use App\Models\Address;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class UsersController extends Controller
{
    
    use GeneralTrait;

    
    public function login(Request $request)
    {
        //
        config()->set( 'auth.defaults.guard', 'user-api' );
        \Config::set('jwt.user', 'App\Models\User'); 
        \Config::set('auth.providers.users.model', \App\Models\User::class);
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:20',
            'password' => 'required|string',
        ]);
        if($validator->fails()){
            return $this->returnErrorMsg($validator->messages()->first());
        }

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = Auth::guard('user-api')->attempt($credentials)) {
                return $this->returnErrorMsg("عفوا, لقد أدخلت بيانات خاطئة");
            }
        } catch (JWTException $e) {
            return $this->returnErrorMsg("لقد حدث خطأ");
        }

        $user = Auth::guard('user-api')->user();
        $user->token = $token;
        return $this->returnData("user logged in successfully", "user", $user);
    }

    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:20',
            'last_name' => 'required|min:2|max:6',
            'mobile' => 'required|min:11|max:20',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return $this->returnErrorMsg($validator->messages()->first());
        }

        $user = User::create([
            'first_name' => $request->get("first_name"),
            'last_name' => $request->get("last_name"),
            'mobile' => $request->get("mobile"),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        $user->profile_pic = "https://i.imgur.com/IIES5AV.png";

        return $this->returnData("user logged in successfully", "user", $user);

    }

    public function logout()
    {
        config()->set( 'auth.defaults.guard', 'user-api' );
        \Config::set('jwt.user', 'App\Models\User'); 
        \Config::set('auth.providers.users.model', \App\Models\User::class);
        
        auth()->logout();
        return $this->returnSuccess("user has logged out successfully");
    }
    public function isResetPass()
    {
        return $this->returnData("reset pass status", "data", 0);
    }
    public function resetPass()
    {
        return $this->returnData("reset your pass now", "data", 0);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        
        //$users_stats["count"] = User::all()->count();
        return $this->returnData("users has gotten successfully", "users", $users);
    }

    public function stats()
    {
        //
        $users_stats["users_latest"] = User::all()->take(3);        
        $users_stats["users_count"] = User::all()->count();
        return $this->returnData("users has gotten successfully", "stats", $users_stats);
    }

    public function search(Request $request)
    {
        
        $users = User::where('id', 'LIKE', '%' . $request->id . '%') 
        ->orWhere('first_name', 'LIKE', '%' . $request->first_name . '%') 
        ->orWhere('last_name', 'LIKE', '%' . $request->last_name . '%') 
        ->get();
        
        return $this->returnData("users has gotten successfully", "users", $users);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->returnData("user has been stored successfully", "user", $user);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $user = Auth::guard('user-api')->user();
        //$user = User::with('addresses')->where("id", $user->id)->get();
        return $this->returnData("user data has been gotten successfully", "user", $user);
    }


    public function checkLoginStatus(Request $request) {
        $user = Auth::guard('user-api')->user();
        if(!$user) {
            return $this->returnErrorMsg("user is not logged in");
        }
        return $this->returnData("user is logged in", "user", $user);
    }

    
    public function getUserOrders(Request $request)
    {
        //
        $user = Auth::guard('user-api')->user();
        $orders = Order::with('products', 'transaction', 'address', 'userpaymentmethod.paymentmethod')->where("user_id", $user->id)->get();
        return $this->returnData("orders have gotten successfully", "orders", $orders);

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $user = Auth::guard('user-api')->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'string|max:30',
            'last_name' => 'string|max:30',
            'mobile' => 'string',
            'email' => 'email|max:30',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'mobile' => $request->get('mobile'),
            'email' => $request->get('email'),
        ]);
        $user->addresses = $user->addresses;

        return $this->returnData("user has been stored successfully", "user", $user);
    }


    public function updateProfilePicture(Request $request)
    {
        $user = Auth::guard('user-api')->user();

        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        
        $file_data = $request->get("file");
        //generating unique file name;
        $file_name = 'image_'.time().'.png';
        @list($type, $file_data) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);
        if($file_data!=""){
            $file_name = 'images/users/'.$file_name;
     		// storing image in storage/app/public Folder
            \Storage::disk('s3')->put($file_name, base64_decode($file_data));
        }

        $user->update([
            'profile_pic' => "https://aldora.s3.ap-south-1.amazonaws.com/".$file_name,
        ]);

        return $this->returnData("profile picture has been updated successfully", "user", $user);


    }

    public function getPaymentMethods(Request $request)
    {
        $user = User::find(Auth::guard('user-api')->user()->id);

        $user_payment_methods = (object) array();
        
        $user_payment_methods->methods = UsersPaymentMethod::with('paymentmethod')->where('user_id', $user->id)->get();

        return $this->returnData("user payment methods has been gotten successfully", "user_payment_methods", $user_payment_methods);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
