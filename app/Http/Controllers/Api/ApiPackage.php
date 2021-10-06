<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Packages;
use App\Models\User;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiPackage extends Controller
{

    use Upload_Files , ApiUserTrait;

    public $apiKey = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SnVZVzFsSWpvaWFXNXBkR2xoYkNJc0luQnliMlpwYkdWZmNHc2lPalkzT1RnM0xDSmpiR0Z6Y3lJNklrMWxjbU5vWVc1MEluMC5ZdkhzOGU4M1VVSWJCUjdmYU5NbVJNWmN6aTZpck9ocy1fQTNDT0VWM3F0ZWlEYl9oV2VvTFlJa3F3VmI2cjhCalNVQldPaDN0SUF2VWVoU0dDT1djQQ==";
    public $paymentMode = "test"; //"live"

    /**
     * ApiPackage constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api'])
            ->only([
                'get_link_to_pay',
                'payment_is_success'
            ]);
    }//end construct



    public function GetPackages()
    {
        $packages = Packages::all();
        return response(['data' => $packages, "message" => "result data", "status" => 200], 200);
    }//end fun


    /**
     * @param Request $request
     * @return mixed
     *
     * Get Link of payMob to pay
     *
     */

    public function get_link_to_pay(Request $request)
    {
        $user = $request->user();

        //validation
        $this->validate($request,[
            'package_id'=>'required|exists:packages,id',
        ]);

        //get package
        $package = Packages::findOrFail($request->package_id);

        if ($package->is_free == "yes") {
            $this->update_user_package($request->package_id,$request->user()->id);
            return response()->json(['data'=>null,'message'=>"package is free",'status'=>201],200);
        }

        //user data
        $userEmail = $user->email;
        $userFirstName = $user->name;
        $userPhoneNumber = $user->phone;

        //order data
        $total_price = $package->price;
        $items = [
            [
                'name'=>"package update",
                'amount_cents'=>$total_price,
                'description'=>"live  mode",
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
         return response()->json(['data'=>$link,'message'=>"success link",'status'=>200],200);
    }//end fun


    /**
     * @param Request $request
     * @return mixed
     *
     */

    public function payment_is_success(Request $request)
    {
        //validation
        $this->validate($request,[
            'package_id'=>'required|exists:packages,id',
        ]);

        $this->update_user_package($request->package_id,$request->user()->id);

        return response()->json(['data'=>null,'message'=>"success package updating",'status'=>200],200);

    }//end fun


    private function update_user_package($package_id,$user_id)
    {
        //create new payment
        $package = Packages::findOrFail($package_id);
        $num_of_days = $package->num_of_days;
        UserPackages::create([
            'user_id'=>$user_id,
            'package_id'=>$package_id,
            'price'=>$package->price,
        ]);

        //update package finished
        $user = User::findOrFail($user_id);

        if (date("Y-m-d",strtotime($user->package_finished_at)) <= date("Y-m-d")) {
            $date = date("Y-m-d");
        }else{
            $date = date("Y-m-d",strtotime($user->package_finished_at));
        }
        $newDateTime =  date('Y-m-d', strtotime($date. " + {$num_of_days} days"));

        $user->update([
            'package_finished_at'=>$newDateTime,
        ]);
        return 0;
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
