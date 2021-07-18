<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use Validator;

use Auth;

use App\Http\Traits\GeneralTrait;

class ReviewsController extends Controller
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
        $reviews = Review::with("product", "user")->get();
        return $this->returnData("reviews has gotten successfully", "reviews", $reviews);
    }

    public function notRevised()
    {
        //
        $reviews = Review::with("product", "user")->where("status", 0)->get();
        return $this->returnData("reviews has gotten successfully", "reviews", $reviews);
    }
    public function cancelled()
    {
        //
        $reviews = Review::with("product", "user")->where("status", -1)->get();
        return $this->returnData("reviews has gotten successfully", "reviews", $reviews);
    }
    public function accepted()
    {
        //
        $reviews = Review::with("product", "user")->where("status", 1)->get();
        return $this->returnData("reviews has gotten successfully", "reviews", $reviews);
    }

    

    public function stats()
    {
        //
        $reviews_stats["all_reviews"] = Review::all()->count();
        $reviews_stats["not_revised"] = Review::all()->where('status', 0)->count();
        $reviews_stats["accepted"] = Review::all()->where('status', 1)->count();
        $reviews_stats["cancelled"] = Review::all()->where('status', -1)->count();
        return $this->returnData("reviews_stats data has gotten successfully", "reviews_stats", compact('reviews_stats'));
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
            'review' => 'required|string|max:1000',
            'product_id' => 'required',
            'stars' => 'required|max:5|min:1',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $review = Review::create([
            'user_id'=> $user->id,
            'product_id' => $request->get('product_id'),
            'review' => $request->get('review'),
            'stars' => $request->get('stars'),
        ]);

        return $this->returnData("review has been stored successfully", "review", $review);
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
        $review = Review::find($request->get("id"));
        $review->status = $request->get("status");
        $review->save();

        return $this->returnData("review has been updated successfully", "review", $review);
    }
    public function change(Request $request)
    {
        //
        $review = Review::find($request->get("id"));
        $review->status = $request->get("status");
        $review->save();


        $reviews = Review::with("product", "user")->get();
        return $this->returnData("reviews has gotten successfully", "reviews", $reviews);
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
