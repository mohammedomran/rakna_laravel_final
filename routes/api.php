<?php


use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return 'you are not auththorized to access this page';
})->name('login');


/****************************************************************///servos routes

Route::group([
    'prefix'=>'otp',
    'namespace'=>'Api'
], function() {
    Route::post("check", "AppdataController@checkOtp");
    Route::post("store", "AppdataController@storeOtp");
    Route::post("isotpavailable", "AppdataController@isotpavailable");
});
/****************************************************************/
//app_data routes

Route::group([
    'prefix'=>'app_data',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "AppdataController@index")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/

//stats routes
Route::group([
    'prefix'=>'stats',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "StatsController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
});

/****************************************************************/

//users routes
Route::group([
    'prefix'=>'users',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "UsersController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("stats", "UsersController@stats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("search", "UsersController@search")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);

    Route::post("login", "UsersController@login");
    Route::post("signup", "UsersController@signup");
    Route::post("logout", "UsersController@logout")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("show", "UsersController@show")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("check_login_status", "UsersController@checkLoginStatus");
    Route::post("orders", "UsersController@getUserOrders")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("update_profile_picture", "UsersController@updateProfilePicture")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/*****************************************************************/

//admins routes
Route::group([
    'prefix'=>'admins',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "AdminsController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api', "checkifadmin"]);
    Route::post("login", "AdminsController@login");
    Route::post("logout", "AdminsController@logout")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("store", "AdminsController@store")->middleware(['checkadmintoken:admin-api', 'auth:admin-api', "checkifadmin"]);
    Route::post("show", "AdminsController@show")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "AdminsController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "AdminsController@destroy")->middleware(['checkadmintoken:admin-api', 'auth:admin-api', "checkifadmin"]);
    Route::post("check_login_status", "AdminsController@checkLoginStatus");

});

/****************************************************************/

//reviews routes
Route::group([
    'prefix'=>'reviews',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {    
    Route::post("stats", "ReviewsController@stats");
    Route::post("accepted", "ReviewsController@accepted");
    Route::post("cancelled", "ReviewsController@cancelled");
    Route::post("index", "ReviewsController@index");
    Route::post("not_revised", "ReviewsController@notRevised");
    Route::post("update", "ReviewsController@update");
    Route::post("change", "ReviewsController@change");
    
    Route::post("store", "ReviewsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/

//complaints routes
Route::group([
    'prefix'=>'complaints',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "ComplaintsController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("not_revised", "ComplaintsController@notRevised")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("replied", "ComplaintsController@replied")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("notreplied", "ComplaintsController@notreplied")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("closed", "ComplaintsController@closed")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("stats", "ComplaintsController@stats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("change", "ComplaintsController@change");
    Route::post("update", "ComplaintsController@update");
    
    Route::post("store", "ComplaintsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/
