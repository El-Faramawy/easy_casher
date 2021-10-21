<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddSectionController extends Controller
{
    public function index(){
$colors= Color::all();
$categories = Category::paginate(15);
$categories2= Category::all();
//return $categories;

        return view('Site/add-sections' , compact('colors' , 'categories', 'categories2'));
    }

    public function create(request $request){
        if (Auth::user()){
          $new = new Category();
        if ($request->cat_image && $request->cat_type == 'image'){
            $file_extension = $request -> cat_image -> getClientOriginalExtension();
            $file_name = time(). '.' . $file_extension;
            $path='Uploads/category/';
            $request->cat_image->move($path , $file_name);
            $new->image = $path . $file_name;
        }
        if ( $request->cat_type == 'color'){
            $new ->color_id =$request->cat_color;
            $request->image = null;
        }
$new->title = $request->cat_name;
$new->display_logo_type = $request->cat_type;
$new->user_id = Auth::user()->id;
$new->added_by_id = $user_id = Auth::user()->id;
$new->save();
//return redirect()->back();
        return redirect()->back()->with(notification('تم الحفظ ','success'));
        }
        else {
//            return view('Site/login');
            return redirect('login')->with(notification('يرجي تسجيل الدخول اولا', 'warning'));
        }


    }

    public function update(request $request){
//        return $request;
        $update = Category::where('id' ,$request->id)->first();
        $update->title = $request->cat_name;
        $update->display_logo_type = $request->cat_type;
        if ($request->cat_image && $request->cat_type == 'image'){
            $file_extension = $request -> cat_image -> getClientOriginalExtension();
            $file_name = time(). '.' . $file_extension;
            $path='Uploads/category/';
            $request->cat_image->move($path , $file_name);
            $update->image = $path . $file_name;
        }
        if ( $request->cat_type == 'color'){
            $update ->color_id =$request->cat_color;
            $update->image = null;
        }
        $update->save();
//        return redirect()->back();
                return redirect()->back()->with(notification('تم التعديل ','success'));

    }

    public function delete(request $request){
        return $request;
    }

}
