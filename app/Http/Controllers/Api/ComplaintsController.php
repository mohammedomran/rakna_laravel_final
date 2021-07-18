<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\User;

use Validator;
use Auth;


use App\Http\Traits\GeneralTrait;

class ComplaintsController extends Controller
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
        $complaints = Complaint::with("order.address", "order.userpaymentmethod.paymentmethod", "user")->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
    }

    public function notRevised()
    {
        //
        $complaints = Complaint::with("order.address", "order.userpaymentmethod.paymentmethod", "user")->where("status", 0)->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
    }
    public function replied()
    {
        //
        $complaints = Complaint::with("order.address", "order.userpaymentmethod.paymentmethod", "user")->where("status", 1)->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
    }
    public function notReplied()
    {
        //
        $complaints = Complaint::with("order.address", "order.userpaymentmethod.paymentmethod", "user")->where("status", -1)->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
    }
    public function closed()
    {
        //
        $complaints = Complaint::with("order.address", "order.userpaymentmethod.paymentmethod", "user")->where("status", 2)->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
    }

    

    public function stats()
    {
        //
        $complaints_stats["all_complaints"] = Complaint::all()->count();
        $complaints_stats["not_revised"] = Complaint::all()->where('status', 0)->count();
        $complaints_stats["replied"] = Complaint::all()->where('status', 1)->count();
        $complaints_stats["closed"] = Complaint::all()->where('status', 2)->count();
        return $this->returnData("complaints_stats data has gotten successfully", "complaints_stats", compact('complaints_stats'));
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
        
        $user = User::find(Auth::guard('user-api')->user()->id);
        $user_id = $user->id;

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|int',
            'content' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $complaint = Complaint::create([
            'content' => $request->get('content'),
            'order_id' => $request->get('order_id'),
            "user_id" => $user_id
        ]);

        return $this->returnData("complaint has been stored successfully", "complaint", $complaint);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $complaint = Complaint::find($request->get("id"));
        $complaint->status = $request->get("status");
        $complaint->save();

        return $this->returnData("complaint has been updated successfully", "complaint", $complaint);
    }
    public function change(Request $request)
    {
        //
        $complaint = Complaint::find($request->get("id"));
        $complaint->status = $request->get("status");
        $complaint->save();


        $complaints = Complaint::with("order.address", "user")->get();
        return $this->returnData("complaints has gotten successfully", "complaints", $complaints);
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
