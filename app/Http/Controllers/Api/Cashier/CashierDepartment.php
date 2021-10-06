<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Http\Traits\NewOrderNotification;
use App\Http\Traits\Upload_Files;
use App\Models\Account;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class CashierDepartment extends Controller
{

    //my traits
    use ApiUserTrait,
        Upload_Files,
        NewOrderNotification ,
        AccountCreating;

    /**
     * CashierDepartment constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:subTradersDepartment'])
            ->only([
                'add_new_cashier',
                'edit_cashier',
                'delete_cashier',
                'searchUsers',
                'getSingleCashier'
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search User
     */

    public function searchUsers(Request $request)
    {
        $this->validate($request,[
            'search_keyWord' =>'nullable',
        ]);
        $users = User::SearchCashier($request->user()->trader_id,$request->search_keyWord)->get();
        return response()->json(['data' => $users],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Get Single User
     */

    public function getSingleCashier(Request $request)
    {
        $this->validate($request,[
            'cashier_id' =>'required|exists:users,id',
        ]);
        return response()->json(User::findOrFail($request->cashier_id),200);
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new Cashier
     *
     */
    public function add_new_cashier(Request $request)
    {
        //validation
        $data = $this->validate($request,[
            'phone_code'=>'required|numeric|digits_between:1,6',
            'phone' => 'required|numeric|digits_between:1,20',
            'name' =>'required',
            'email'=>'nullable',
            'software_type' =>'required|in:ios,android',
        ]);
        $this->validate($request,[
            'permissions' =>'array|nullable',
            'permissions.*' =>'exists:permissions,id|nullable',
        ]);
        //check email exist or not
        if ($request->email){
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
        $data['user_type'] = 'child';
        $data['parent_id'] = $request->user()->id;
        $data['trader_id'] = $request->user()->trader_id;
        $data['is_confirmed'] = $request->user()->is_confirmed;
        $user=User::create($data);
        //make Account
        $this->createAccount( $user->name ,$user->id ,'App/Models/User' , $user->id , $request->user()->id);
        //add permission
        if (is_array($request->permissions)) $user->givePermissionTo($request->permissions);
        //make token
        $user=$this->add_passport_token_to_user($user);
        //----------notifications send-----------------------------
        $title_notify = " كاشير جديد  " ;
        $desc_notify = " كاشير جديد ثمت اضافته الى  حساب التاجر {$request->user()->name}" ;
        $this->notify($title_notify,$desc_notify,route('users.index'),'newUser');
        AdminNotification::create([
            'ar_title' =>$title_notify ,
            'ar_desc' => $desc_notify,
            'from_user_id' => $user->id,
            'type' => 'newUser',
        ]);
        return response()->json($user,200);
    }//end function

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Edit Cashier
     *
     */
    public function edit_cashier(Request $request)
    {
        $this->validate($request,[
            'cashier_id'=>'required|exists:users,id',
        ]);
        //validation
        $data = $this->validate($request,[
            'phone_code'=>'required|numeric|digits_between:1,6',
            'phone' => Rule::unique('users')->ignore($request->cashier_id),
            'name' =>'required',
            'email' =>Rule::unique('users')->ignore($request->cashier_id),
            'software_type' =>'required|in:ios,android',
        ]);
        $this->validate($request,[
            'permissions' =>'array|nullable',
            'permissions.*' =>'exists:permissions,id|nullable',
        ]);

        $data['user_type'] = 'child';
         User::findOrFail($request->cashier_id)->update($data);
        $cashier = User::findOrFail($request->cashier_id);
        //make Account
        $cashier->account()->update([
            'display_title' =>$cashier->name
        ]);
        //edit permission
        $old_permissions = $cashier->permissions()->pluck('name')->toArray();
        if (count($old_permissions)>0){
            $cashier->revokePermissionTo($old_permissions);
        }
        if (is_array($request->permissions)) $cashier->givePermissionTo($request->permissions);
        //make token
        return response()->json($this->add_passport_token_to_user($cashier),200);
    }//end class

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     *
     * Delete Cashier
     *
     */
    public function delete_cashier(Request $request)
    {
        $this->validate($request,[
            'cashier_id'=>'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->cashier_id);
        $user->account()->delete();
        $user->delete();
        return response()->json(['message'=>'cashier had been deleted'],200);
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
}//end class
