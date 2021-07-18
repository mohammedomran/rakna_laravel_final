<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Editor;
use App\Models\Admin;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class EditorsController extends Controller
{
    
    use GeneralTrait;

    
    public function login(Request $request)
    {
        //
        config()->set( 'auth.defaults.guard', 'editor-api' );
        \Config::set('jwt.user', 'App\Models\Editor'); 
        \Config::set('auth.providers.users.model', \App\Models\Editor::class);
        
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = Auth::guard('editor-api')->attempt($credentials)) {
                return $this->returnErrorMsg("invalid credentials");
            }
        } catch (JWTException $e) {
            return $this->returnErrorMsg("couldn't create token");
        }

        $editor = Auth::guard('editor-api')->user();
        $editor->token = $token;
        $editor->role="editor";
        return $this->returnData("editor logged in successfully", "admin", $editor);
    }
    
    
    public function WelcomeEditor()
    {
        return response()->json("Hello, editor");
    }


    public function logout()
    {
        config()->set( 'auth.defaults.guard', 'editor-api' );
        \Config::set('jwt.user', 'App\Models\Editor'); 
        \Config::set('auth.providers.users.model', \App\Models\Editor::class);
        
        auth()->logout();
        return $this->returnData("editor logged in successfully", "admin", $editor);
    }


    public function checkLoginStatus(Request $request) {
        $editor = Auth::guard('editor-api')->user();
        if(!$editor) {
            return $this->returnErrorMsg("editor is not logged in");
        }
        return $this->returnData("editor is logged in", "admin", $editor);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $editors_stats["editors"] = Editor::all();
        
        $editors_stats["count"] = Editor::all()->count();
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
        $editor = Editor::find(Auth::guard('editor-api')->user()->id);
        return $this->returnData("editor data has been gotten successfully", "admin", $editor);

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
        Editor::where("id", $request->get("id"))->delete();
        $editors = Editor::all();
        return $this->returnData("editor has been deleted successfully", "editors", $editors);

    }
}
