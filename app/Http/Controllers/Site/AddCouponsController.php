<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AddCouponsController extends Controller
{
    public function index(){
        $coupones = Coupon::all();
        return view('Site/add-offer', compact('coupones') );
    }

    public function create(request $request){
//return $request;
        $new = new Coupon();
        $new->title = $request->title;
        $new->type = $request->offerType;
        $new->value =$request->offer_type;
        $new->user_id = 36;
        $new->added_by_id = 36;
        $new->save();
        return redirect()->back();
//        return redirect()->with(notification('تم الحفظ ','success'));


    }

    public function update(request $request){
      $update = Coupon::where('id' , $request->id)->first();
      $update ->title = $request->title;
      $update ->type = $request->offerType;
      $update ->value = $request->offer_type;
      $update ->user_id =36;
      $update ->added_by_id = 36;
      $update->save();
      return redirect()->back();
        //        return redirect()->with(notification('تم التعديل ','warning'));


    }

    public function delete(request $request){
        return $request;
    }
}
