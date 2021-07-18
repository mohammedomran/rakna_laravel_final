<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

use Validator;
use Auth;


use App\Http\Traits\GeneralTrait;

class ColorsController extends Controller
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
        $colors["colors"] = Color::all();
        $colors["count"] = Color::count();
        return $this->returnData("colors has gotten successfully", "colors_data", $colors);
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
            'color' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $color = Color::create([
            'color' => $request->get('color'),
            'code' => $request->get('code'),
        ]);

        return $this->returnData("color has been stored successfully", "color", $color);
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
        $color = Color::find($request->get("id"));
        return $this->returnData("color has gotten successfully", "color", $color);
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
        $color = Color::find($request->get("id"));
        $color->color = $request->get("color");
        $color->code = $request->get("code");
        $color->save();
        return $this->returnData("color has been updated successfully", "color", $color);

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
        Color::where("id", $request->get("id"))->delete();
        $colors = Color::all();
        return $this->returnData("color has been deleted successfully", "colors", $colors);

    }
}
