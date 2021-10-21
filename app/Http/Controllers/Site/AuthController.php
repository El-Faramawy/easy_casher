<?php

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Http\Traits\NewOrderNotification;
use App\Http\Traits\Upload_Files;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;


class AuthController extends Controller
{
    //my traits
    use ApiUserTrait,
        Upload_Files,
        NewOrderNotification ,
        AccountCreating;

    public function post_login(Request $request)
    {
        $rules= [
            'phone' => 'required',
            'phone_code'=>'required',
        ];
        $messages = [
            'phone.required'=>'رقم الهاتف مطلوب',
            'phone_code.required'=>'كود الهاتف مطلوب'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails())
            return response()->json(['type'=>'error','message'=>$validator->errors()->getMessages()]);

        $user = User::where(['phone_code'=>'00'.$request->phone_code,'phone'=>$request->phone])->first();
        if($user) {
            \auth()->login($user);
            $return_data=$this->checkIfUserCanLogin($user);
            if ($return_data == 406)
                return response()->json(['type'=>'error','message'=>['تم حظر المستخدم']]);
            return response()->json(['type'=>'success','url'=>url('/')],200);
        }
        else{
            return response()->json(['type'=>'register']); // go to register
        }
    }
    //===================================================================
    public function register(Request $request)
    {
        //validation
        $validation = Validator::make($request->all(),[
            'phone_code'=>'required',
            'phone' => 'required',
            'name' =>'required',
//            'email' =>'nullable|email',
//            'software_type' =>'required|in:ios,android',
        ],[
            'phone.required'=>'رقم الهاتف مطلوب',
            'phone_code.required'=>'كود الهاتف مطلوب',
            'name.required' =>'الاسم مطلوب',
        ]);
        //check email exist or not
//        if ($request->email !=null){
//            $type = 'email';
//            $email_check = $this->check_if_email_or_phone_exist($type);
//            if ($email_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$email_check);
//        }
        // validation errors
        if ($validation->fails()) return response()->json(['message'=>$validation->errors()->getMessages(),'type'=>'error']);
        //check phone exist or not
        $user_phones = User::pluck('phone')->toArray();
        if (in_array($request->phone,$user_phones) ) return response()->json(['message'=>["هذا الهاتف موجود مسبقا"],'type'=>'error']);
        //insert data
        $data = $request->only('phone_code','phone','name');
        $data['password']=bcrypt(123456);
        //upload logo
        $data['logo']= $this->createImageFromTextManual('users' , $request->name , 256 , '#000', '#fff');

        $user=User::create($data);
        //-------------
        $user->is_confirmed = "accepted";
        $user->software_type = 'web';
        $user->is_login='connected';
        $user->phone_code = '00'.$request->phone_code;
        //-------------
        $user->trader_id = $user->id;
        $user->save();
        \auth()->login($user);
        //make Account
        $this->createAccount( $user->name ,$user->id ,'App/Models/User' , $user->id , $user->id);
        //add permissions
        $user->givePermissionTo(Permission::where('guard_name','web')->pluck('id')->toArray());
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
        return response()->json(['type'=>'success','url'=>url('/')],200);
    }

    //===================================================================
    public function logout(){
        $user=\auth()->user();
        $user->logout_time=time();
        $user->is_login='not_connected';
        $user->save();
        Auth::logout();
        return redirect('/')->with(notification('تم تسجيل الخروج','error'));
    }


}//end
