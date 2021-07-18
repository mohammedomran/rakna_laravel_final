<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;


class WishlistsController extends Controller
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
        $user = User::find(Auth::guard('user-api')->user()->id);
        $wishlist = Wishlist::where("user_id", $user->id)->first();

        if(count((array)$wishlist) == 0) {
            $wishlist = Wishlist::create([
                "user_id" => $user->id,
            ]);
        }


        $wishlist = Wishlist::find($wishlist->id);

        $wishlist->products()->sync($request->get('product_id'), false);

        $wishlist = $wishlist::with('user', 'products')->get();
        return $this->returnData("wishlist has been updated successfully", "wishlist", $wishlist);

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
        $user = User::find(Auth::guard('user-api')->user()->id);
        $wishlist = Wishlist::with("products")->where("user_id", $user->id)->get();
        if(!count($wishlist)) {
            $wishlist = Wishlist::create([
                "user_id" => $user->id,
            ]);

        }

        return $this->returnData("wishlist has been gotten successfully", "wishlist", $wishlist[0]);

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
        //
        
        $user = User::find(Auth::guard('user-api')->user()->id);
        $wishlist = Wishlist::where("user_id", $user->id)->first();
        $wishlist = Wishlist::find($wishlist->id);

        $wishlist->products()->detach($request->product_id);

        $wishlist = $wishlist::with('user', 'products')->get();
        return $this->returnData("wishlist has been deleted successfully", "wishlist", $wishlist);

    }
}
