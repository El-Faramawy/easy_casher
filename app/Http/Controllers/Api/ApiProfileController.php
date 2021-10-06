<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiProfileController extends Controller
{
    use Upload_Files , ApiUserTrait;
    public function __construct()
    {
        $this->middleware('auth:api')->only(['getCurrentUserData']);
        $this->middleware('auth:api')->only(['update_profile']);
        $this->middleware('auth:api')->only(['marketData']);
    }


    public function getCurrentUserData(Request $request)
    {
        $user = User::where('id',$request->user()->id)->first();
        $user=$this->add_passport_token_to_user($user);
     return response()->json($user,200);
    }


    public function update_profile(Request $request)
    {
        //validation
        $data = $this->validate($request,[
            'name' =>'required',
            'phone_code' =>'required',
            'phone' =>'required',
            'email' =>'nullable|email',
            'logo' =>'nullable|file|image',
            'address' =>'nullable',
            'notes' =>'nullable',
            'longitude' =>'nullable',
            'latitude' =>'nullable',
            'tax_amount' =>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'currency' =>'nullable',
        ]);
        if ($request->tax_amount == null){
            $data['tax_amount']=0;
        }
        //check email exist or not
        if ($request->email !=null){
            $type = 'email';
            $email_check = $this->check_if_email_or_phone_exist($type , $request->user()->id);
            if ($email_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$email_check);
        }else{
            $data['email']=$request->user()->email;
        }
        //check phone exist or not
        $type ='phone';
        $phone_check = $this->check_if_email_or_phone_exist($type , $request->user()->id);
        if ($phone_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$phone_check);

        //upload logo
        if ($request->hasFile('logo')){
            $data['logo'] = $this->uploadFiles('users',$request->file('logo'),$request->user()->logo);
        }else{
            $data['logo'] = $request->user()->logo;
        }

       $request->user()->update($data);
        $user =   $request->user();
        $user =$this->add_passport_token_to_user($user);
        return response()->json($user,200);
    }


    public function marketData(Request $request)
    {
        $trader_id = $request->user()->trader_id;
        return response()->json( User::findOrFail($trader_id),200);

    }


    public function check_if_email_or_phone_exist($type ,$id)
    {
        $input[$type] = \request()->$type;
        $rules = array("{$type}" => Rule::unique('users')->ignore($id));
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            if ($type == 'email'){
                return 403;
            }else
                return 402;
        }
        return 200;
    }

}//end class
