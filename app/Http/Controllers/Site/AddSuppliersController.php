<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\SuppliersRequest;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddSuppliersController extends Controller
{
    public function index(){
        $suppliers = Client::where('client_type' , 'supplier')->paginate(10);
        $categories2= Category::all();
        return view('Site/suppliers' , compact('suppliers' , 'categories2' ));
    }

    public function create(SuppliersRequest $request){
        try {


            if (Auth::user()) {
                $new = new Client();
                $new->client_type = 'supplier';
                $new->name = $request->name;
                $new->email = $request->email;
                $new->phone = $request->phone;
                $new->address = $request->address;
                $new->phone_code = '0020';
                $new-> user_id= Auth::user()->trader_id;
                $new-> added_by_id= Auth::user()->id;
                $new->save();
                return redirect()->back()->with(notification('تم اضافة مورد بنجاح ', 'success'));
            }
            else{

                return redirect('login')->with(notification('يرجي تسجيل الدخول اولا', 'warning'));
            }
        }catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }

    }

    public function update(SuppliersRequest $request){
        try {
            if (Auth::user()) {

                $update = Client::where('id', $request->id)->first();
                $update->name = $request->name;
                $update->email = $request->email;
                $update->phone = $request->phone;
                $update->address = $request->address;
                $update->save();
                return redirect()->back()->with(notification('تم تعديل بيانات المورد ', 'warning'));
            }
            else{
                return redirect('login')->with(notification('يرجي تسجيل الدخول اولا', 'warning'));
            }
        }catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }

    }

    public function delete(request $request){
//        return $request;
        $delete= Client::where('id' ,$request->id)->first();
        $delete->delete();
        $delete->save();
        return redirect()->back()->with(notification('تم حذف المورد ','danger'));

    }
}
