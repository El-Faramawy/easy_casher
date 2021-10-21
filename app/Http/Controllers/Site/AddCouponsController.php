<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddCouponsController extends Controller
{
    public function index(){
        $coupones = Coupon::all();
        return view('Site/add-offer', compact('coupones') );
    }

    public function create(request $request){
        if (Auth::user()) {
//return $request;
            $new = new Coupon();
            $new->title = $request->title;
            $new->type = $request->offerType;
            $new->value = $request->offer_type;
            $new->user_id = Auth::user()->id;
            $new->added_by_id = Auth::user()->id;
            $new->save();
//        return redirect()->back();
            return redirect()->back()->with(notification('تم الحفظ ', 'success'));
        }else{
//    return view('Site/login');
            return redirect('login')->with(notification('يرجي تسجيل الدخول اولا', 'warning'));
        }

    }

    public function update(request $request){
      $update = Coupon::where('id' , $request->id)->first();
      $update ->title = $request->title;
      $update ->type = $request->offerType;
      $update ->value = $request->offer_type;
      $update->save();
//      return redirect()->back();
                return redirect()->back()->with(notification('تم التعديل ','warning'));


    }

    public function delete(request $request){
        return $request;
    }
}
