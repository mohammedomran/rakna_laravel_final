<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class AdminsController extends Controller
{
    
    use GeneralTrait;

    
    public function login(Request $request)
    {
        //
        config()->set( 'auth.defaults.guard', 'admin-api' );
        \Config::set('jwt.user', 'App\Models\Admin'); 
        \Config::set('auth.providers.users.model', \App\Models\Admin::class);
        
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = Auth::guard('admin-api')->attempt($credentials)) {
                return $this->returnErrorMsg("invalid credentials");
            }
        } catch (JWTException $e) {
            return $this->returnErrorMsg("couldn't create token");
        }

        $admin = Auth::guard('admin-api')->user();
        $admin->token = $token;
        $admin->role="admin";
        return $this->returnData("admin logged in successfully", "admin", $admin);
    }


    public function logout()
    {
        config()->set( 'auth.defaults.guard', 'admin-api' );
        \Config::set('jwt.user', 'App\Models\Admin'); 
        \Config::set('auth.providers.users.model', \App\Models\Admin::class);
        
        auth()->logout();
        return $this->returnSuccess("admin has logged out successfully");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins_stats["admins"] = Admin::where("role", "admin")->get();
        
        $admins_stats["count"] = Admin::where("role", "admin")->count();
        return $this->returnData("admins has gotten successfully", "admins_stats", $admins_stats);
    }
    public function indexEditors()
    {
        //
        $editors_stats["editors"] = Admin::where("role", "editor")->get();
        
        $editors_stats["count"] = Admin::where("role", "admin")->count();
        return $this->returnData("editors has gotten successfully", "editors_stats", $editors_stats);
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
            'email' => 'required|email|max:30|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $admin = Admin::create([
            'email' => $request->get('email'),
            'role' => "admin",
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->returnData("admin has been stored successfully", "admin", $admin);

    }
    public function storeEditor(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:30|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $editor = Admin::create([
            'email' => $request->get('email'),
            'role' => "editor",
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->returnData("editor has been stored successfully", "editor", $editor);

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
        $admin = Admin::find(Auth::guard('admin-api')->user()->id);
        return $this->returnData("admin data has been gotten successfully", "admin", $admin);

    }

    public function checkLoginStatus(Request $request) {
        $admin = Auth::guard('admin-api')->user();
        if(!$admin) {
            return $this->returnErrorMsg("admin is not logged in");
        }
        return $this->returnData("admin is logged in", "admin", $admin);
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
        $admin = Admin::find(Auth::guard('admin-api')->user()->id);
        
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

        $admin->update([
            'first_name' => $request->get("first_name"),
            'last_name' => $request->get("last_name"),
            'mobile' => $request->get("mobile"),
            'password' => bcrypt($request->get("password")),
            'status' => 1,
        ]);

        return $this->returnData("admin data has been stored successfully", "admin", $admin);
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
        Admin::where("id", $request->get("id"))->delete();
        $admins = Admin::where("role", "admin")->get();
        return $this->returnData("admin has been deleted successfully", "admins", $admins);

    }
    
    public function destroyEditor(Request $request)
    {
        //
        Admin::where("id", $request->get("id"))->delete();
        $editors = Admin::where("role", "editor")->get();
        return $this->returnData("editor has been deleted successfully", "editors", $editors);

    }
}
