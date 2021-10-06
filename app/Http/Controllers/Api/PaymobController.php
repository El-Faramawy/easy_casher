<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymobController extends Controller
{
    public $apiKey = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SnVZVzFsSWpvaWFXNXBkR2xoYkNJc0luQnliMlpwYkdWZmNHc2lPalkzT1RnM0xDSmpiR0Z6Y3lJNklrMWxjbU5vWVc1MEluMC5ZdkhzOGU4M1VVSWJCUjdmYU5NbVJNWmN6aTZpck9ocy1fQTNDT0VWM3F0ZWlEYl9oV2VvTFlJa3F3VmI2cjhCalNVQldPaDN0SUF2VWVoU0dDT1djQQ==";
    public $paymentMode = "test"; //"live"

    public function index()
    {
        //user data
        $userEmail = "mostafaelraw123@gmail.com";
        $userFirstName = "mostafa";
        $userPhoneNumber = "01025130204";

        //order data
        $total_price = 100;
        $items = [
            [
                'name'=>"mostafa El-raw",
                'amount_cents'=>20,
                'description'=>"test  mode",
                'quantity'=>1,
            ]
        ];

        //basic data
        $integration_id = $this->paymentMode =="test"?174857:209511;
        $billing_data = $this->get_billing_data($userEmail,$userFirstName,$userPhoneNumber);

        //first step
        $auth_token = $this->first_step_for_auth($this->apiKey);
        if ($auth_token == "error") {
            return response()->json(['data'=>null,'message'=>"error",'status'=>404],200);
        }

        //second step
        $order_id =  $this->second_step_for_register_order($auth_token,$total_price,$items);
        if ($order_id == "error") {
            return response()->json(['data'=>null,'message'=>"error",'status'=>404],200);
        }

        //third step
        $payment_key = $this->third_step_for_payment_key($auth_token,$order_id,$total_price,$billing_data,$integration_id);
        if ($payment_key == "error") {
            return response()->json(['data'=>null,'message'=>"error",'status'=>404],200);
        }

        //final step
        $link =  $this->fourth_step_for_iframe_link($payment_key);
        return view('welcome',compact('link'));
        //  return response()->json(['data'=>['link'=>$link,'order_id'=>$order_id,'auth_token'=>$auth_token],'message'=>"success link",'status'=>200],200);

    }//end fun


    private function first_step_for_auth($api_key)
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $api_key,
        ]);

        if ($response->successful()) {
            return $response['token'];
        }

        return "error";
    }//end fun


    private function second_step_for_register_order($authToken,$amount,$items)
    {

        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token' => $authToken,
            'delivery_needed'=>false,
            'amount_cents'=>$amount,
            'currency'=>"EGP",
            "items"=>$items,
        ]);

        if ($response->successful()) {
            return $response['id'];
        }
        return "error";
    }//end fun


    private function third_step_for_payment_key($authToken,$orderId,$amount,$billing_data,$integration_id)
    {
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token' => $authToken,
            'amount_cents'=>$amount,
            'expiration'=>3600,
            'order_id'=>$orderId,
            'billing_data'=>$billing_data,
            'currency'=>"EGP",
            'integration_id'=>$integration_id,
            'lock_order_when_paid'=>"false"
        ]);

        if ($response->successful()) {
            return $response['token'];
        }
        return "error";

    }//end fun


    private function fourth_step_for_iframe_link($payment_key)
    {
        return "https://accept.paymob.com/api/acceptance/iframes/169006?payment_token={$payment_key}";
    }//end fun



    private function get_billing_data($email,$firstName,$phoneNumber)
    {
        return [
            "apartment"=>"NA",
            "email"=> $email?$email:"test@exa.com",
            "floor"=> "NA",
            "first_name"=>$firstName?"user default":$firstName,
            "street"=> "NA",
            "building"=> "NA",
            "phone_number"=> $phoneNumber?(string)$phoneNumber:"+86(8)9135210487",
            "shipping_method"=>"NA",
            "postal_code"=> "NA",
            "city"=> "NA",
            "country"=>"NA",
            "last_name"=> "NA",
            "state"=> "NA"
        ];

    }//end fun


}//end class
