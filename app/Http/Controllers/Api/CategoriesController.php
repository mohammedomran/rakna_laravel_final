<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use App\Models\Product;

class CategoriesController extends Controller
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
        
        $categories_data["categories"] = Category::with('products')->get();
        $categories_data["categories_count"] = Category::all()->count();
        return $this->returnData("categories_data has gotten successfully", "categories_data", $categories_data);
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
            'name' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $category = Category::create([
            'name' => $request->get('name'),
        ]);

        return $this->returnData("category has been stored successfully", "category", $category);
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
        $category = Category::find($request->get("id"));
        return $this->returnData("category has gotten successfully", "category", $category);
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
        $category = Category::find($request->get("id"));
        $category->name = $request->get("name");
        $category->save();
        return $this->returnData("category has been updated successfully", "category", $category);

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
        Category::where("id", $request->get("id"))->delete();
        Product::where("category_id", $request->get("id"))->delete();
        $categories = Category::with('products')->get();
        return $this->returnData("category has been deleted successfully", "categories", $categories);

    }
}
