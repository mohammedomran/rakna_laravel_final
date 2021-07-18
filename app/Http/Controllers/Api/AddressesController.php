<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

use Validator;
use Auth;


use App\Http\Traits\GeneralTrait;

class AddressesController extends Controller
{

    use GeneralTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
    
     public function index()
    {
        //
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
        $user = Auth::guard('user-api')->user();

        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $address = Address::create([
            'user_id'=> $user->id,
            'address' => $request->get('address'),
        ]);

        return $this->returnData("address has been stored successfully", "address", $address);
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
        
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $address = Address::find($request->address_id);

        return $this->returnData("address has gotten successfully", "address", $address);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
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
            'address_id' => 'required',
            'address' => 'required|string|max:255',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $address = Address::find($request->address_id);
        $address->update([
            'address' => $request->get('address'),
        ]);

        return $this->returnData("address has been updated successfully", "address", $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        //
        $user = Auth::guard('user-api')->user();
        
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $address = Address::find($request->address_id);
        $address->delete();

        return $this->returnData("address has been deleted successfully", "address", $address);
    }
}
