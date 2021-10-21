<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddProductCategory extends Controller
{
    public function index(){

        $colors= Color::all();
        $categories = Category::all();
        $products = Product::paginate(10);

            return view('Site/add-products' , compact('colors' , 'categories' , 'products'));
    }

    public function create(request $request){
        if (Auth::user()) {
//       return $request;
            $new = new Product();

            $new->title = $request->title;
            $new->product_cost = $request->product_cost;
            $new->product_price = $request->product_price;
            $new->product_type = $request->sellType;
            $new->sku = $request->sku;
            $new->stock_type = $request->stockType;
            $new->stock_amount = $request->stock_amount;
            $new->display_logo_type = $request->viewType;
            if ($request->cat_image && $request->viewType == 'image') {
                $file_extension = $request->cat_image->getClientOriginalExtension();
                $file_name = time() . '.' . $file_extension;
                $path = 'Uploads/category/';
                $request->cat_image->move($path, $file_name);
                $new->image = $path . $file_name;
            }
            if ($request->viewType == 'color') {
                $new->color_id = $request->cat_color;
                $request->image = null;
            }
            $new->user_id = Auth::user()->id;
            $new->added_by_id = Auth::user()->id;
            $new->save();
            $new_product_category = new ProductCategory();
            $new_product_category->product_id = $new->id;
            $new_product_category->category_id = $request->category_id;
            $new_product_category->save();
                return redirect()->back()->with(notification('تم الحفظ ','success'));

        }
        else{
            return redirect('login')->with(notification('يرجي تسجيل الدخول اولا', 'warning'));
        }

    }

    public function update(request $request){
//        return $request;
        $update = Product::where('id' ,$request->id)->first();
        $update->title = $request->title;
        $update->product_type = $request->sellType;
        $update->product_price = $request->product_price;
        $update->product_cost = $request->product_cost;
        $update->sku = $request->sku;
//        $update->sku = $request->sku;
        $update->stock_type = $request->stockType;
        $update->stock_amount = $request->stock_amount;
        if ($request->stock_type == 'out_stock'){
        $update->stock_amount = 0;
        }
        if ( $request->viewType == 'color'){
            $update ->color_id =$request->cat_color;
            $update ->image = null;
        }
        if ($request->cat_image && $request->viewType == 'image'){
            $file_extension = $request -> cat_image -> getClientOriginalExtension();
            $file_name = time(). '.' . $file_extension;
            $path='Uploads/category/';
            $request->cat_image->move($path , $file_name);
            $update->image = $path . $file_name;
            $update->color_id = null;
        }
        $update->display_logo_type = $request->viewType;
        $update->color_id = $request->cat_color;
        $update->save();
//        return redirect()->back();
                return redirect()->back()->with(notification('تم التعديل ','warning'));

    }

    public function delete(request $request){
        return $request;
    }
}
