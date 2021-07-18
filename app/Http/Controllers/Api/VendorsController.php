<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Shipment;
use App\Models\Bill;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class VendorsController extends Controller
{
    
    use GeneralTrait;

    
    public function login(Request $request)
    {
        //
        config()->set( 'auth.defaults.guard', 'vendor-api' );
        \Config::set('jwt.user', 'App\Models\Vendor'); 
        \Config::set('auth.providers.users.model', \App\Models\Vendor::class);
        
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = Auth::guard('vendor-api')->attempt($credentials)) {
                return $this->returnErrorMsg("invalid credentials");
            }
        } catch (JWTException $e) {
            return $this->returnErrorMsg("couldn't create token");
        }

        $vendor = Auth::guard('vendor-api')->user();
        $vendor->token = $token;
        return $this->returnData("vendor logged in successfully", "vendor", $vendor);
    }

    public function logout()
    {
        config()->set( 'auth.defaults.guard', 'vendor-api' );
        \Config::set('jwt.user', 'App\Models\Vendor'); 
        \Config::set('auth.providers.users.model', \App\Models\Vendor::class);
        
        auth()->logout();
        return $this->returnSuccess("vendor has logged out successfully");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendors = Vendor::all();
        
        return $this->returnData("vendors has gotten successfully", "vendors", $vendors);
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
            'email' => 'required|email|max:30|unique:vendors',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $vendor = Vendor::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->returnData("vendor has been stored successfully", "vendor", $vendor);

    }

    
    public function stats()
    {
        //
        $vendors_stats["vendors_latest"] = Vendor::all()->take(3);        
        $vendors_stats["vendors_count"] = Vendor::all()->count();
        return $this->returnData("vendors has gotten successfully", "vendors_stats", $vendors_stats);
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
        $vendor = Vendor::find(Auth::guard('vendor-api')->user()->id);
        return $this->returnData("vendor data has been gotten successfully", "vendor", $vendor);

    }

    public function checkLoginStatus(Request $request) {
        $vendor = Auth::guard('vendor-api')->user();
        if(!$vendor) {
            return $this->returnErrorMsg("vendor is not logged in");
        }
        return $this->returnData("vendor is logged in", "vendor", $vendor);
    }

    public function shipmentsStats(Request $request) {
        
        $vendor = Auth::guard('vendor-api')->user();
        $shipments = Shipment::with("bills")->where("vendor_id", $vendor->id)->get();
        return $this->returnData("shipments has been gotten successfully", "shipments", $shipments);
    }

    public function shipments(Request $request) {
        
        $vendor = Auth::guard('vendor-api')->user();
        $shipments = Shipment::with("bills")->where("vendor_id", $vendor->id)->get();
        return $this->returnData("shipments has been gotten successfully", "shipments", $shipments);
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
        $vendor = Vendor::find(Auth::guard('vendor-api')->user()->id);
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            //return response()->json($validator->errors()->toJson(), 400);
            return $this->returnErrorMsg("error");
        }

        $vendor->update([
            'first_name' => $request->get("first_name"),
            'last_name' => $request->get("last_name"),
            'mobile' => $request->get("mobile"),
            'password' => bcrypt($request->get("password")),
            'status' => 1,
        ]);

        return $this->returnData("vendor data has been stored successfully", "vendor", $vendor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Vendor::where("id", $request->get("id"))->delete();
        $vendors = Vendor::all();
        return $this->returnData("vendor has been deleted successfully", "vendors", $vendors);

    }
}
