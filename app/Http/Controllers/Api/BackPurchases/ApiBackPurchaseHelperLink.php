<?php

namespace App\Http\Controllers\Api\BackPurchases;

use App\Http\Controllers\Controller;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBackPurchaseHelperLink extends Controller
{
    use Upload_Files , AccountCreating;

    /**
     *
     * ApiNormalPurchaseHelperLink constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:backPurchasesDepartment'])
            ->only([
                'categories',
                'searchProducts',
                'getSingleProduct',

                'searchSuppliers',
                'getSingleSupplier',
                'addNewSupplier'
            ]);
    }//end construct


    /*
     *
     *
     * From Products Department
     *
     *
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * All Categories
     */

    public function categories(Request $request)
    {

        $categories = Category::SearchCategory(null)
            ->where('user_id',$request->user()->trader_id)
            ->withCount('products')
            ->get();
        return response()->json(['data'=>$categories],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search Product
     */

    public function searchProducts(Request $request)
    {
        if ($request->has('category_id')&& $request->category_id != 'all'){
            $this->validate($request,[
                'category_id' => 'required|exists:categories,id'
            ]);
        }

        $this->validate($request,[
            'search_keyWord'=>'nullable',
            'category_id' => 'required'
        ]);
        $rows = Product::SearchProduct($request->search_keyWord , $request->category_id)
            ->where('user_id',$request->user()->trader_id)
            ->with('single_category')
            ->get();
        return response()->json(['data'=>$rows],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * get Single Product
     */

    public function getSingleProduct(Request $request)
    {
        $this->validate($request,[
            'product_id'=>'required|exists:products,id'
        ]);
        $row = Product::where([
            'id'=>$request->product_id ,
            'user_id'=>$request->user()->trader_id
        ])->with('single_category')
            ->firstOrFail();
        return response()->json($row, 200);
    }//end function



    /*
    *
    *
    * From Supplier
    *
    *
    */


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search Suppliers
     */
    public function searchSuppliers(Request $request)
    {
        $this->validate($request,[
            'search_keyWord'=>'nullable'
        ]);
        $rows = Client::SearchClient($request->search_keyWord)
            ->where([
                'user_id'=>$request->user()->trader_id,
                'client_type'=>'supplier'
            ])
            ->get();
        return response()->json(['data'=>$rows],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Get Single Supplier
     *
     */
    public function getSingleSupplier(Request $request)
    {
        $this->validate($request,[
            'supplier_id'=>'required|exists:clients,id'
        ]);
        return response()->json(
            Client::where([
                'id'=>$request->supplier_id ,
                'user_id'=>$request->user()->trader_id
            ])->firstOrFail(),
            200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new Supplier
     */

    public function addNewSupplier(Request $request)
    {
        $data = $this->validate($request,[
            'name'=>'required',
            'email'=>'nullable',
            'phone_code'=>'nullable',
            'phone'=>'required',
            'address'=>'nullable',
            'notes'=>'nullable',

        ]);
        if ($request->email){
            //check email exist or not
            $type = 'email';
            $email_check = $this->check_if_email_or_phone_exist($type);
            if ($email_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$email_check);

        }
        //check phone exist or not
        $type = 'phone';
        $phone_check =$this->check_if_email_or_phone_exist($type);
        if ($phone_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$phone_check);


        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        $data['client_type'] = 'supplier';
        $client = Client::create($data);
        //add balance
        $this->createAccount( $client->name ,$client->id ,'App/Models/Client' ,$request->user()->trader_id , $request->user()->id);

        return response()->json(['message'=>'new Supplier had been created'],200);
    }//end function


    /*===============================================================*/
    /*===============================================================*/
    /*=======================    Helper    ==========================*/
    /*===============================================================*/
    /*===============================================================*/

    public function check_if_email_or_phone_exist($type)
    {
        $input[$type] = \request()->$type;
        $rules = array("{$type}" => "unique:clients,{$type}");
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
