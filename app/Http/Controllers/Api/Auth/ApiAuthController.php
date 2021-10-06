<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Http\Traits\NewOrderNotification;
use App\Http\Traits\Upload_Files;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class ApiAuthController extends Controller
{
    //my traits
    use ApiUserTrait,
        Upload_Files,
        NewOrderNotification ,
        AccountCreating;


    public function __construct()
    {
        $this->middleware(['auth:api'])->only(['logout']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Register Function
     *
     */
    public function register(Request $request)
    {
        //validation
        $data = $this->validate($request,[
            'phone_code'=>'required|numeric|digits_between:1,6',
            'phone' => 'required|numeric|digits_between:1,20',
            'name' =>'required',
            'email' =>'nullable|email',
            'software_type' =>'required|in:ios,android',
           ]);
        //check email exist or not
        if ($request->email !=null){
            $type = 'email';
            $email_check = $this->check_if_email_or_phone_exist($type);
            if ($email_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$email_check);
        }
        //check phone exist or not
        $type = 'phone';
        $phone_check =$this->check_if_email_or_phone_exist($type);
        if ($phone_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$phone_check);
        //insert data
        $data['password']=bcrypt(123456);
        //upload logo
        if ($request->hasFile('logo')){
            $data['logo']=$this->uploadFiles('users',$request->file('logo'),null);
        }else{
            $data['logo']= $this->createImageFromTextManual('users' , $request->name , 256 , '#000', '#fff');
        }
        $user=User::create($data);
        //-------------
        $user->is_confirmed = "accepted";
        //-------------
        $user->trader_id = $user->id;
        $user->save();
        //make Account
        $this->createAccount( $user->name ,$user->id ,'App/Models/User' , $user->id , $user->id);
        //add permissions
        $user->givePermissionTo(Permission::where('guard_name','web')->pluck('id')->toArray());
        //make token
        $user=$this->add_passport_token_to_user($user);
        //----------notifications send-----------------------------
        $title_notify = 'تاجر جديد';
        $desc_notify = 'تاجر جديد انضم الى التطبيق';
        $this->notify($title_notify,$desc_notify,route('users.index'),'newUser');
        AdminNotification::create([
            'ar_title' =>$title_notify ,
            'ar_desc' => $desc_notify,
            'from_user_id' => $user->id,
            'type' => 'newUser',
         ]);
        return response()->json($user,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * login
     *
     *
     */

    public function login(Request $request)
    {
        $credentials= $this->validate($request,[
                    'phone' => 'required|numeric|digits_between:1,20',
                    'phone_code'=>'required|numeric|digits_between:1,6',
                ]);
        $credentials['password']=123456;
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $return_data=$this->checkIfUserCanLogin($user);
            if ($return_data == 406){
                return response()->json(['message'=>'this user had blocked'],406);
            }
            $user=$this->add_passport_token_to_user($user);
            return response()->json($user,200);
        }
        return response()->json(['message'=>'this phone not registered'],404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * logout
     *
     *
     */
    public function logout(Request $request)
    {
        //get user and change its login status
        $user=$request->user();
        $user->logout_time=time();
        $user->is_login='not_connected';
        $user->save();
        //remove user token
        $request->user()->token()->revoke();
        return response()->json(['message' => 'good logout'],200);
    }//end function

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * get User BY phone
     */
    public function getUserByPhone(Request $request)
    {
        $user = User::where('phone',$request->phone)->first();
        if (!$user){
            return response()->json(['message' => 'user not exists'],404);

        }
        return response()->json($user,200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * All Permissions
     *
     */

    public function allPermissions()
    {
       $permissions=  Permission::where('guard_name','web')->get();
        return response()->json(['data'=>$permissions],200);
    }

    /*===============================================================*/
    /*===============================================================*/
    /*=======================    Helper    ==========================*/
    /*===============================================================*/
    /*===============================================================*/

    public function check_if_email_or_phone_exist($type)
    {
        $input[$type] = \request()->$type;
        $rules = array("{$type}" => "unique:users,{$type}");
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
           if ($type == 'email'){
               return 403;
           }else
               return 402;
        }
        return 200;
    }


    /*
      Permission::create(['name' => 'subTradersDepartment']);
      Permission::create(['name' => 'productsDepartment']);
      Permission::create(['name' => 'salesDepartment']);
      Permission::create(['name' => 'purchasesDepartment']);
      Permission::create(['name' => 'clientsDepartment']);
      Permission::create(['name' => 'suppliersDepartment']);
      Permission::create(['name' => 'selectsAndReportDepartment']);
      Permission::create(['name' => 'backSalesDepartment']);
      Permission::create(['name' => 'backPurchasesDepartment']);
      Permission::create(['name' => 'expensesDepartment']);
      Permission::create(['name' => 'revenuesDepartment']);
      Permission::create(['name' => 'settingsDepartment']);
     */

}//end class
