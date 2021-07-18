<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Appdata;
use App\Models\Transaction;
use Validator;
use Auth;

use App\Http\Traits\GeneralTrait;

class OrdersController extends Controller
{

    
    use GeneralTrait;

    protected function cURL($url, $json)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    /**
     * Send GET cURL request to paymob servers.
     *
     * @param  string  $url
     * @return array
     */
    protected function GETcURL($url)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::with("products", "transaction", "address", "user", "userpaymentmethod.paymentmethod")->get();
        return $this->returnData("orders has gotten successfully", "orders", $orders);
    }

    public function notRevised()
    {
        //
        $orders = Order::with("products", "address", "user", "userpaymentmethod.paymentmethod")->where("status", 0)->get();
        return $this->returnData("orders has gotten successfully", "orders", $orders);
    }
    public function cancelled()
    {
        //
        $orders = Order::with("products", "address", "user", "userpaymentmethod.paymentmethod")->where("status", -1)->get();
        return $this->returnData("orders has gotten successfully", "orders", $orders);
    }
    public function delivered()
    {
        //
        $orders = Order::with("products", "address", "user", "userpaymentmethod.paymentmethod")->where("status", 2)->get();
        return $this->returnData("orders has gotten successfully", "orders", $orders);
    }
    public function underDelivery()
    {
        //
        $orders = Order::with("products", "address", "user", "userpaymentmethod.paymentmethod")->where("status", 1)->get();
        return $this->returnData("orders has gotten successfully", "orders", $orders);
    }

    

    public function stats()
    {
        //
        $orders_stats["all_orders"] = Order::all()->count();
        $orders_stats["not_revised"] = Order::all()->where('status', 0)->count();
        $orders_stats["delivered"] = Order::all()->where('status', 2)->count();
        $orders_stats["under_delivery"] = Order::all()->where('status', 1)->count();
        $orders_stats["cancelled"] = Order::all()->where('status', -1)->count();
        return $this->returnData("orders_stats data has gotten successfully", "orders_stats", compact('orders_stats'));
    }



    public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'products' => 'required',
        ]);

        if($validator->fails()){
            return $this->returnErrorMsg($validator->messages()->first());
        }


        $IDs = [];
        for ($i=0; $i < count($request->get("products")); $i++) { 
            $IDs[] = $request->get("products")[$i]["id"];
        }
        $products = Product::whereIn("id", $IDs)->get();
        if(count($products) != count($request->get("products"))) {
            return $this->returnErrorMsg("يبدو أن بعض المنتجات تم تغييرها, يرجي مسح العربة وتعبئتها مجددا");
        }

        for ($i=0; $i < count($request->get("products")); $i++) { 
            if($request->get("products")[$i]["quantity"] > 4) {
                return $this->returnErrorMsg("عفوا, لا يمكنك اختيار اكثر من 4 قطع لنفس المنتج");
            }
        }

        //get user data
        $user = Auth::guard('user-api')->user();

        
        

        //count order total price
        $total_price = 0;
        $delivery = 0;
        $taxes = 0;

        
        
        $total_price = 0;
        for ($j=0; $j < count($products); $j++) {
            if($products[$j]["price_discount"] != 0) {  
                $total_price += ($products[$j]["price"]-$products[$j]["price_discount"])*$request->get("products")[$j]["quantity"];
            } elseif($products[$j]["percentage_discount"]) {
                $total_price += ($products[$j]["price"]-$products[$j]["price"]*$products[$j]["percentage_discount"]/100)*$request->get("products")[$j]["quantity"];
            } else {
                $total_price += $products[$j]["price"]*$request->get("products")[$j]["quantity"];
            }
        }
        

        //store order at first
        $user_id = $user->id;

        $order = Order::create([
            'user_id' => $user_id,
            'address_id' => $request->get("address"),
            'price' => $total_price,
        ]);
        $products_from_frontend = $request->get('products');
        for ($i=0; $i < count($products_from_frontend); $i++) {
            $order->products()->attach($products[$i]["id"], ['color_id' => $products_from_frontend[$i]["selected_color"]["id"], 'quantity'=>$products_from_frontend[$i]["quantity"]]);
        }

        //Authentication Request
        $client = new Client();
        $response = $client->post('https://accept.paymobsolutions.com/api/auth/tokens', [
            'headers'=>[
                'Content-Type' => 'application/json'
            ],
            'body'=> json_encode(['api_key'=>'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TkRZME1Ua3NJbTVoYldVaU9pSnBibWwwYVdGc0luMC51azlPR25VUXJfcEhta1NkVEs0OHBYX0ZCWTdOd2ZFTlVMTGx5a0J0WngxXzFCcVlYbEpPNTlKWjRHUFppSFFSVE9wc2h5QklqVlJ5YVlSZmx4UUZpQQ=='])
        ]);
        $token = json_decode($response->getBody()->getContents())->token;
        if(!$token) {
            return $this->returnData("لا يمكن إجراء عمليات دفع الآن, قم بالمحاولة لاحقا", "token", $token);
        }


        
        

        //Order Registration API
        $response = $client->post('https://accept.paymobsolutions.com/api/ecommerce/orders', [
            'headers'=>[
                'Content-Type' => 'application/json'
            ],
            'body'=> json_encode([
                "auth_token"=> $token,
                "delivery_needed"=> "false",
                "amount_cents"=> $total_price*100,
                "currency"=> "EGP",
                "items"=> []
            ])
        ]);

        
        $response = json_decode($response->getBody()->getContents());
        $orderId = $response->id;

        
        //Payment Key Request
        $response = $client->post('https://accept.paymobsolutions.com/api/acceptance/payment_keys', [
            'headers'=>[
                'Content-Type' => 'application/json'
            ],
            'body'=> json_encode([
                "auth_token" => $token,
                "amount_cents" => $total_price*100,
                "expiration" => 36000,
                "order_id" => $orderId,    // id obtained in step 2
                "currency" => "EGP",
                "integration_id" => 124499, // card integration_id will be provided upon signing up,
                "lock_order_when_paid" => "true",
                "billing_data" => [
                    "apartment"=> "N/A", 
                    "email"=> $user->email, 
                    "floor"=> "N/A", 
                    "first_name"=> $user->first_name, 
                    "street"=> "N/A", 
                    "building"=> "N/A", 
                    "phone_number"=> $user->mobile, 
                    "shipping_method"=> "N/A", 
                    "postal_code"=> "N/A", 
                    "city"=> "N/A", 
                    "country"=> "N/A", 
                    "last_name"=> $user->last_name, 
                    "state"=> "N/A"
                ],
            ])
        ]);
        $response = json_decode($response->getBody()->getContents());
        $payment_token = $response->token;

        //store paymob orderId, authToken, paymentToken in our DB
        $transaction = Transaction::create([
            'order_id' => $order->id,
            'orderId' => $orderId,
            'authToken' => $token,
            'paymentToken' => $payment_token,
        ]);
        
        $payment_base_link = "https://accept.paymob.com/api/acceptance/iframes/123086?payment_token=";
        $payment_link = $payment_base_link.$payment_token;

        return $this->returnData("payment token has been generated successfully", "payment_link", $payment_link);
    }

    public function checkOrderStatus(Request $request) {
        
        //get latest user's order data
        $user = Auth::guard('user-api')->user();
        $user = User::with("orders.transaction")->where("id", $user->id)->get();
        
        if($user[0]->orders[count($user[0]->orders)-1]->transaction == null) {
            return $this->returnData("لم يتم إتمام عملية الدفع", "payment_status", false);
        }
        $orderId = $user[0]->orders[count($user[0]->orders)-1]->transaction->orderId;
        $authToken = $user[0]->orders[count($user[0]->orders)-1]->transaction->authToken;
        $transactionId = $user[0]->orders[count($user[0]->orders)-1]->transaction->transactionId;

        

        
        if($transactionId == null) {
            //get order data from paymob

            //step 1 - Authentication Request
            $client = new Client();
            $response = $client->post('https://accept.paymobsolutions.com/api/auth/tokens', [
                'headers'=>[
                    'Content-Type' => 'application/json'
                ],
                'body'=> json_encode(['api_key'=>'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TkRZME1Ua3NJbTVoYldVaU9pSnBibWwwYVdGc0luMC51azlPR25VUXJfcEhta1NkVEs0OHBYX0ZCWTdOd2ZFTlVMTGx5a0J0WngxXzFCcVlYbEpPNTlKWjRHUFppSFFSVE9wc2h5QklqVlJ5YVlSZmx4UUZpQQ=='])
            ]);
            $token = json_decode($response->getBody()->getContents())->token;
            //step 2 - get order details
            $transactions = $this->GETcURL(
                "https://accept.paymobsolutions.com/api/acceptance/transactions?page=1&token='.$token.'"
            );

            $transactions = $transactions->results;
            for ($i=0; $i < count($transactions); $i++) { 
                if($orderId==$transactions[$i]->order->id) {
                    if(!$transactions[$i]->is_voided && !$transactions[$i]->is_refunded && $transactions[$i]->success) {
                        $transaction = Transaction::where("orderId", $orderId)->get()[0];
                        Transaction::find($transaction->id);
                        $transaction->transactionId = $transactions[$i]->id;
                        $transaction->payment_status = $transactions[$i]->success;
                        $transaction->save();
                        return $this->returnData("تم دفع هذا الطلب بنجاح", "payment_status", $transactions[$i]->success);
                    } else {
                        $transaction = Transaction::where("orderId", $orderId)->get()[0];
                        Transaction::find($transaction->id);
                        $transaction->transactionId = $transactions[$i]->id;
                        $transaction->payment_status = -1;
                        return $this->returnData("لم يتم إتمام عملية الدفع", "payment_status", $transactions[$i]->success);
                    }
                } else {
                    //couldn't find the order in page 1
                    $transactions = $this->GETcURL(
                        "https://accept.paymobsolutions.com/api/acceptance/transactions?page=2&token='.$token.'"
                    );
            
                    $transactions = $transactions->results;
                    for ($i=0; $i < count($transactions); $i++) { 
                        if($orderId==$transactions[$i]->order->id) {
                            if(!$transactions[$i]->is_voided && !$transactions[$i]->is_refunded && $transactions[$i]->success) {
                                $transaction = Transaction::where("orderId", $orderId)->get()[0];
                                Transaction::find($transaction->id);
                                $transaction->transactionId = $transactions[$i]->id;
                                $transaction->payment_status = $transactions[$i]->success;
                                $transaction->save();
                                return $this->returnData("تم دفع هذا الطلب بنجاح", "payment_status", $transactions[$i]->success);
                            } else {
                                $transaction = Transaction::where("orderId", $orderId)->get()[0];
                                Transaction::find($transaction->id);
                                $transaction->transactionId = $transactions[$i]->id;
                                $transaction->payment_status = -1;
                                return $this->returnData("لم يتم إتمام عملية الدفع", "payment_status", $transactions[$i]->success);
                            }
                        } else {
                            
                            $transaction = Transaction::where("orderId", $orderId)->get()[0];
                            Transaction::find($transaction->id);
                            $transaction->transactionId = $transactions[$i]->id;
                            $transaction->payment_status = -1;
                            return $this->returnErrorMsg("لم يتم إيجاد حالة الطلب");
                        }
                    }
                }
            }
        } else {
            
            //step 1 - Authentication Request
            $client = new Client();
            $response = $client->post('https://accept.paymobsolutions.com/api/auth/tokens', [
                'headers'=>[
                    'Content-Type' => 'application/json'
                ],
                'body'=> json_encode(['api_key'=>'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TkRZME1Ua3NJbTVoYldVaU9pSnBibWwwYVdGc0luMC51azlPR25VUXJfcEhta1NkVEs0OHBYX0ZCWTdOd2ZFTlVMTGx5a0J0WngxXzFCcVlYbEpPNTlKWjRHUFppSFFSVE9wc2h5QklqVlJ5YVlSZmx4UUZpQQ=='])
            ]);
            $token = json_decode($response->getBody()->getContents())->token;
            //get transaction status from paymob
            $transaction = $this->GETcURL(
                "https://accept.paymobsolutions.com/api/acceptance/transactions/".$transactionId."?token=".$token.""
            );

            if(!$transaction->is_voided && !$transaction->is_refunded && $transaction->success) {
                $x = Transaction::where("orderId", $orderId)->get()[0];
                Transaction::find($transaction->id);
                $x->payment_status = $transaction->success;
                $x->save();
                return $this->returnData("تم دفع هذا الطلب بنجاح", "payment_status", $transaction->success);
            } else {
                $x = Transaction::where("orderId", $orderId)->get()[0];
                Transaction::find($transaction->id);
                $x->payment_status = -1;
                $x->save();
                return $this->returnData("لم يتم إتمام عملية الدفع", "payment_status", $transactions[$i]->success);
            }
            
        }
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
        $user = User::find(Auth::guard('user-api')->user()->id);
        $user_id = $user->id;

        $order = Order::create([
            'user_id' => $user_id,
            'address_id' => 80,
            'userpaymentmethod_id' => 11,
        ]);

        $products = $request->get('products');
        for ($i=0; $i < count($products); $i++) {
            $order->products()->attach($products[$i]["id"], ['color_id' => $products[$i]["color"]["id"], 'quantity'=>$products[$i]["quantity"]]);
        }

        return $this->returnData("order has been stored successfully", "order", $request->get('products'));

    }
    

    public function track(Request $request)
    {

        $order_status = Order::where('id', $request->order_id)->get("status");
        return $this->returnData("order_status has been gotten successfully", "order_status", $order_status->first());

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
        $order = Order::find($request->get("id"));
        $order->status = $request->get("status");
        $order->save();

        return $this->returnData("order has been updated successfully", "order", $order);
    }
    public function change(Request $request)
    {
        //
        $order = Order::find($request->get("id"));
        $order->status = $request->get("status");
        $order->save();


        $orders = Order::with("products", "address", "user", "userpaymentmethod.paymentmethod")->get();
        return $this->returnData("order has been updated successfully", "orders", $orders);
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
