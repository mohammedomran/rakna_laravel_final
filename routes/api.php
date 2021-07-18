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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/user', function (Request $request) {
    return 'you are not auththorized to access this page';
})->name('login');



/****************************************************************/
//servos routes

Route::group([
    'prefix'=>'servos',
    'namespace'=>'Api'
], function() {
    Route::get("index", "AppdataController@servosData");
    Route::get("{id}/{status}", "AppdataController@editServosData");
});
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
//sensors routes

Route::group([
    'prefix'=>'sensors',
    'namespace'=>'Api'
], function() {
    Route::get("index", "AppdataController@sensorsData");
    Route::get("{id}/{status}", "AppdataController@editSensorsData");
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

//shipments routes
Route::group([
    'prefix'=>'shipments',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("show", "ShipmentsController@show")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
});
/****************************************************************/

//banners routes
Route::group([
    'prefix'=>'banners',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "BannersController@index");
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
    Route::post("is_reset_pass", "UsersController@isResetPass");
    Route::post("reset_pass", "UsersController@resetPass");
    Route::post("signup", "UsersController@signup");
    Route::post("logout", "UsersController@logout")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("show", "UsersController@show")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("check_login_status", "UsersController@checkLoginStatus");
    Route::post("orders", "UsersController@getUserOrders")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("update", "UsersController@update")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("update_profile_picture", "UsersController@updateProfilePicture")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("payment-methods", "UsersController@getPaymentMethods")->middleware(['checkusertoken:user-api', 'auth:user-api']);
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

/*****************************************************************/

//vendors routes
Route::group([
    'prefix'=>'vendors',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("stats", "VendorsController@stats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("index", "VendorsController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("store", "VendorsController@store")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "VendorsController@destroy")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    
    Route::post("login", "VendorsController@login");
    Route::post("update", "VendorsController@update")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
    Route::post("logout", "VendorsController@logout")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
    Route::post("show", "VendorsController@show")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
    Route::post("shipments_stats", "VendorsController@shipmentsStats")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
    Route::post("shipments", "VendorsController@shipments")->middleware(['checkvendortoken:vendor-api', 'auth:vendor-api']);
    Route::post("check_login_status", "VendorsController@checkLoginStatus");
    
});

/*****************************************************************/

//editors routes
Route::group([
    'prefix'=>'editors',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "AdminsController@indexEditors")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("login", "AdminsController@login");
    Route::post("logout", "AdminsController@logout")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("store", "AdminsController@storeEditor")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "AdminsController@destroyEditor")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("show", "AdminsController@show")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("check_login_status", "AdminsController@checkLoginStatus");

});

/*****************************************************************/

//products routes
Route::group([
    'prefix'=>'products',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "ProductsController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("store", "ProductsController@store")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "ProductsController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("stats", "ProductsController@stats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("get_offers_stats", "ProductsController@getOffersStats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("search", "ProductsController@search")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "ProductsController@destroy")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);

    Route::post("show_products", "ProductsController@showProducts");
    Route::post("return_products", "ProductsController@returnProducts"); //-
    Route::post("filter", "ProductsController@filter"); //-
    Route::post("search-for-product", "ProductsController@searchForProduct"); //-
    Route::post("show", "ProductsController@show");
    Route::post("most_selled", "ProductsController@mostSelled");
    Route::post("offers", "ProductsController@getOffers");
});

/****************************************************************/

//categories routes
Route::group([
    'prefix'=>'categories',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "CategoriesController@index");
    Route::post("store", "CategoriesController@store")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "CategoriesController@destroy")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("show", "CategoriesController@show")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "CategoriesController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
});

/****************************************************************/

//colors routes
Route::group([
    'prefix'=>'colors',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "ColorsController@index");
    Route::post("store", "ColorsController@store")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delete", "ColorsController@destroy")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("show", "ColorsController@show")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "ColorsController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
});

/****************************************************************/

//wishlists routes
Route::group([
    'prefix'=>'wishlists',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("store", "WishlistsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("show", "WishlistsController@show")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("delete", "WishlistsController@destroy")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/
//orders routes
Route::group([
    'prefix'=>'orders',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "OrdersController@index")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("not_revised", "OrdersController@notRevised")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("cancelled", "OrdersController@cancelled")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("delivered", "OrdersController@delivered")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("under_delivery", "OrdersController@underDelivery")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("stats", "OrdersController@stats")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("change", "OrdersController@change")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "OrdersController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    
    Route::post("store", "OrdersController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("pay", "OrdersController@pay")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("check_order_status", "OrdersController@checkOrderStatus")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("track", "OrdersController@track");
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
    Route::post("stats", "ReviewsController@stats")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("accepted", "ReviewsController@accepted")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("cancelled", "ReviewsController@cancelled")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("index", "ReviewsController@index")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("not_revised", "ReviewsController@notRevised")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("update", "ReviewsController@update")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    Route::post("change", "ReviewsController@change")->middleware(['checkusertoken:admin-api', 'auth:admin-api']);
    
    Route::post("store", "ReviewsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/

//addresses routes
Route::group([
    'prefix'=>'addresses',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("store", "AddressesController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("show", "AddressesController@show")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("update", "AddressesController@update")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("delete", "AddressesController@delete")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/

//users payment methods routes
Route::group([
    'prefix'=>'users-payment-methods',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("store", "UsersPaymentMethodsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    //Route::post("update", "UsersPaymentMethodsController@update")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("delete", "UsersPaymentMethodsController@delete")->middleware(['checkusertoken:user-api', 'auth:user-api']);
    Route::post("make_primary", "UsersPaymentMethodsController@makePrimary")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/

//payment methods routes
Route::group([
    'prefix'=>'payment-methods',
    'middleware'=>[
        'checkapipassword',
    ],
    'namespace'=>'Api'
], function() {
    Route::post("index", "PaymentMethodsController@index");
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
    Route::post("change", "ComplaintsController@change")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    Route::post("update", "ComplaintsController@update")->middleware(['checkadmintoken:admin-api', 'auth:admin-api']);
    
    Route::post("store", "ComplaintsController@store")->middleware(['checkusertoken:user-api', 'auth:user-api']);
});

/****************************************************************/
