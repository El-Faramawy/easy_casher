<?php

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{


    public function post_login(Request $request)
    {
        return $request->all();
        $user = User::where(['phone'=>$request->phone,'phone_code'=>'00'.$request->phone_code])->first();
        if ($user){
            Auth::login($user);
            return response()->json(['type'=>'success','url'=>url('/')]);
        }else
            return response()->json(['type'=>'error','message'=>'رقم الهاتف غير موجود']);

    }

    //===================================================================
    public function logout(){
        Auth::logout();
        return redirect('/')->with(notification('تم تسجيل الخروج','error'));
    }


}//end
