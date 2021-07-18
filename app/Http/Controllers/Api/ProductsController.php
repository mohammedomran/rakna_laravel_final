<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Branchimage;
use Validator;

use App\Http\Traits\GeneralTrait;

class ProductsController extends Controller
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
        $products = Product::with('category', 'reviews', 'orders', "colors", "wishlists")->get();
        return $this->returnData("producs has gotten successfully", "products", $products);
    }

    public function showProducts()
    {
        //
        $products = Product::all();
        return $this->returnData("producs has gotten successfully", "products", $products);
    }


    public function returnProducts(Request $request)
    {
        $products = Product::with("colors")->whereIn("id", $request->get('products'))->get();
        return $this->returnData("producs has gotten successfully", "products", $products);
    }



    public function filter(Request $request)
    {
        $filtered_products = [];
        $products = Product::with("colors")->whereIn("category_id", $request->get('selected_categories'))->
        where("price", ">=", $request->get('minPrice'))->
        where("price", "<=", $request->get('maxPrice'))->get();
        
        for ($i=0; $i < count($products); $i++) { 
            for ($j=0; $j < count($products[$i]["colors"]); $j++) { 
                if(in_array($products[$i]["colors"][$j]["id"], $request->get("selected_colors"))) {
                    if(!in_array($products[$i], $filtered_products)) {
                        $filtered_products[] = $products[$i];
                    }
                }
            }
        }
        return $this->returnData("producs has gotten successfully", "products", $filtered_products);
    }


    public function stats()
    {
        //
        $products_stats["latest_products"] = Product::with('category', 'reviews', 'orders')->get()->take(3);
        $products_stats["count"] = Product::all()->count();
        return $this->returnData("products_stats has gotten successfully", "products_stats", $products_stats);
    }

    public function getOffers()
    {
        //
        $offers = Product::query()->with("reviews")->orderBy('updated_at','DESC')->where('price_discount', '!=' , 0)->orWhere('percentage_discount', '!=' , 0)->get();
        return $this->returnData("offers has gotten successfully", "offers", $offers);
    }
    
    public function getOffersStats()
    {
        //
        $offers["all_offers"] = Product::query()->orderBy('updated_at','DESC')->where('price_discount', '!=' , 0)->orWhere('percentage_discount', '!=' , 0)->get();
        $offers["count"] = Product::query()->orderBy('updated_at','DESC')->where('price_discount', '!=' , 0)->orWhere('percentage_discount', '!=' , 0)->count();

        return $this->returnData("offers has gotten successfully", "offers", $offers);
    }

    public function mostSelled()
    {
        $products = [];
        return $this->returnData("mostselled products have been gotten successfully", "products", $products);
    }



    public function search(Request $request)
    {
        
        $products = Product::with("category", "reviews", "orders")
        ->where('id', 'LIKE', '%' . $request->data . '%') 
        ->orWhere('name', 'LIKE', '%' . $request->data . '%') 
        ->get();
        
        return $this->returnData("products has gotten successfully", "products", $products);

    }

    public function searchForProduct(Request $request)
    {
        
        $products = Product::where('name', 'LIKE', '%' . $request->data . '%')->get()->take(5);
        
        return $this->returnData("products has gotten successfully", "products", $products);

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
            'name' => 'required|string',
            'category_id' => 'required|string',
            'selected_colors' => 'required',
            'description' => 'required|string',
            'price' => 'required|string',
            'price_discount' => 'string',
            'price_percentage' => 'string',
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
            $file_name = 'images/'.$file_name;
     		// storing image in storage/app/public Folder
            \Storage::disk('s3')->put($file_name, base64_decode($file_data));
        }
        
        $product = Product::create([
            'name' => $request->get('name'),
            'category_id' => $request->get('category_id'),
            'description' => htmlspecialchars($request->get('description')),
            'price' => $request->get('price'),
            'price_discount' => $request->get('price_discount'),
            'price_percentage' => $request->get('price_percentage'),
            'main_image' => "https://aldorahouse.s3-eu-west-1.amazonaws.com/".$file_name,
        ]);

        //store product's available colors
        $product->colors()->sync($request->get('selected_colors'), true);
        
        
        //store product's branch images
        $files_names = [];
        for ($i=0; $i < count($request->get("files")); $i++) {
            $file_data = $request->get("files")[$i];
            $file_name = 'image_'.time().'.png';
            @list($type, $file_data) = explode(';', $file_data);
            @list(, $file_data) = explode(',', $file_data);
            if($file_data!=""){
                $file_name = 'images/'.$file_name;
                $files_names[] = "https://aldorahouse.s3-eu-west-1.amazonaws.com/".$file_name;
                // storing image in storage/app/public Folder
                \Storage::disk('s3')->put($file_name, base64_decode($file_data));
            }
        }
        foreach($files_names as $file_name) {
            $branchimage = new Branchimage();
            $branchimage->product_id = $product->id;
            $branchimage->image = $file_name;
            $branchimage->save();
        }

        $product = Product::find($product->id);
        $product->branch_images = $product->branchimages;
        $product->colors = $product->colors;

        
        return $this->returnData("product has been stored successfully", "product", $product);

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
        $product = Product::find($request->productId);
        $product->reviews = Review::with('user')->where('product_id', $request->productId)->where("status", 1)->get();
        $product->simillar_products = Product::where("category_id", $product->category->id)->get()->take(7);
        $product->branch_images = Branchimage::where("product_id", $product->id)->get();
        return $this->returnData("produc has gotten successfully", "product", $product);

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
        $product = Product::find($request->product_id);
        
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'price_discount' => 'int',
            'percentage_discount' => 'int',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product->update([
            'price_discount' => $request->get("price_discount"),
            'percentage_discount' => $request->get("percentage_discount"),
        ]);

        return $this->returnData("produc data has been stored successfully", "product", $product);
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
        Product::where("id", $request->get("id"))->delete();
        $products = Product::with('category', 'reviews', 'orders', "colors", "wishlists")->get();
        return $this->returnData("product has been deleted successfully", "products", $products);

    }
}
