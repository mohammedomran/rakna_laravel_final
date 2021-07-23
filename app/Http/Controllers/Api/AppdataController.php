<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appdata;
use App\Models\Otp;
use Auth;


use App\Http\Traits\GeneralTrait;


class AppdataController extends Controller
{

    
    use GeneralTrait;
    /*
    DB_CONNECTION=mysql
    DB_HOST=aa1sn1rqldkit1v.cn9hga52ou34.eu-west-1.rds.amazonaws.com
    DB_PORT=3306
    DB_DATABASE=rakna_db
    DB_USERNAME=raknra
    DB_PASSWORD=rakna2021*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function isotpavailable(Request $request)
    {
        $id = Auth::guard('user-api')->user()->id;
        $otps = Otp::where("user_id", $id)->where("status", 1)->get();

        if(count($otps)) {
            return $this->returnErrorMsg("Sorry, you can't reserve a new park right now");
        }
        return $this->returnSuccess("you can reserve a new park");
    }
    public function storeOtp(Request $request)
    {
        $id = Auth::guard('user-api')->user()->id;
        $otp = Otp::create([
            'user_id' => $id,
            'otp' => $request->get("otp"),
            'place' => $request->get("place"),
        ]);

        return $this->returnData("otp status has been updated successfully", "otp", $otp);
    }
    
    public function checkOtp(Request $request)
    {
        $otp = Otp::where("otp", $request->get("otp"))->get();
        if(!count($otp)) {
            return $this->returnErrorMsg("Sorry, wrong OTP");
        }

        $otp = Otp::find($otp[0]->id);
        if($otp->status == 0) {
            return $this->returnErrorMsg("Sorry, wrong OTP");
        }
        $otp->status = 0;
        $otp->save();

        return $this->returnData("otp status has been gotten & its status updated successfully", "otp", $otp);
    }


    public function index()
    {
        //
        $app_data = Appdata::all();
        return $this->returnData("app data has been gotten successfully", "app_data", $app_data);

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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }
}
