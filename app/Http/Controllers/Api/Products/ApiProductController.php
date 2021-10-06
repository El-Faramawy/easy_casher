<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
//use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiProductController extends Controller
{
    use Upload_Files;

    /**
     * ApiProductController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:productsDepartment'])
            ->only([
                'searchProducts',
                'getSingleProduct',
                'addNewProduct',
                'editProduct',
                'deleteProduct',
                'categories',
                'getSingleProductByBarcode',
            ]);
        $this->middleware(['auth:api'])
            ->only([
                'addLocalBarcode',
            ]);

    }//end construct

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
     * Search products
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
     * Get Single product
     *
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



     public function getSingleProductByBarcode(Request $request)
        {
            $this->validate($request,[
                'barcode_code'=>'required|exists:products,barcode_code'
            ]);
            $row = Product::where([
                'barcode_code'=>$request->barcode_code ,
                'user_id'=>$request->user()->trader_id
            ])->with('single_category')
                ->firstOrFail();
            return response()->json($row, 200);
        }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new product
     */

    public function addNewProduct(Request $request)
    {
        $request->validate([
            'display_logo_type'=>'required|in:image,color',
            'category_id'=>'required|exists:categories,id',
        ]);
        $image_validate = $request->display_logo_type == 'image' ?'required':'nullable';
        $color_validate = $request->display_logo_type != 'image' ?'required|exists:colors,id':'nullable';

        $data = $this->validate($request,[
            'title'=>'required',
            'product_type'=>'required|in:unit,weight',
            'product_cost'=>"required|regex:/^\d+(\.\d{1,2})?$/",
            'product_price'=>"required|regex:/^\d+(\.\d{1,2})?$/",
            'sku'=>"unique:products,sku|nullable",
            'barcode_code'=>"unique:products,barcode_code|nullable",
            'barcode_image'=>"nullable|image|mimes:jpeg,jpg,png,gif|max:10000",
            'stock_type'=>'required|in:in_stock,out_stock',
            'stock_amount'=>"required|regex:/^\d+(\.\d{0,1,2})?$/",
            'display_logo_type'=>'required|in:image,color',
            'image'=>"{$image_validate}|image|mimes:jpeg,jpg,png,gif|max:10000",
            'color_id'=>"{$color_validate}",
        ]);
        //images uploaded
        if ($request->hasFile('barcode_image')){
            $data['barcode_image']=$this->uploadFiles('products',$request->file('barcode_image'),null);
        }else{
            $data['barcode_image']= null;
        }
        if ($request->hasFile('image')){
            $data['image']=$this->uploadFiles('products',$request->file('image'),null);
        }else{
            $data['image']= $this->createImageFromTextManual('products' , $request->title , 256 , '#000', '#fff');
        }

        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;

        $trader = User::find( $request->user()->trader_id );

        if ( $trader->package_finished_at != null && $trader->package_finished_at < date('Y-m-d') )
        {
            return response()->json(['message'=>'You Package Ended', 'code'=> 201],200);
        }

        $user_products_count = Product::where([ ['user_id','=', $request->user()->trader_id ] ])->get();

        if ( $trader->package_finished_at == null && $user_products_count->count() >= 3 )
        {
            return response()->json(['message'=>'You Must subscribe in application', 'code'=> 202],200);
        }

        $product = Product::create($data);
        ProductCategory::create([
            'category_id' =>$request->category_id,
            'product_id' =>$product->id,
        ]);
        return response()->json(['message'=>'new product had been created', 'code'=> 200],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Edit products
     *
     */

    public function editProduct(Request $request)
    {
        $request->validate([
            'display_logo_type'=>'required|in:image,color',
            'category_id'=>'required|exists:categories,id',
            'product_id'=>'required|exists:products,id',
        ]);

        $image_validate = $request->display_logo_type == 'image' ?'required':'nullable';
        $color_validate = $request->display_logo_type != 'image' ?'required|exists:colors,id':'nullable';

        $data = $this->validate($request,[
            'title'=>'required',
            'product_type'=>'required|in:unit,weight',
            'product_cost'=>"required|regex:/^\d+(\.\d{1,2})?$/",
            'product_price'=>"required|regex:/^\d+(\.\d{1,2})?$/",
            'sku' => ['nullable',Rule::unique('products')->ignore($request->product_id)],
            'barcode_code' => ['nullable',Rule::unique('products')->ignore($request->product_id)],
            'barcode_image' => "nullable|image|mimes:jpeg,jpg,png,gif|max:10000",
            'stock_type'=>'required|in:in_stock,out_stock',
            'stock_amount'=>"required|regex:/^\d+(\.\d{1,2})?$/",
            'display_logo_type'=>'required|in:image,color',
            'image'=>"{$image_validate}|image|mimes:jpeg,jpg,png,gif|max:10000",
            'color_id'=>"{$color_validate}",
        ]);
        $row = Product::where([
            'id'=>$request->product_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();

        $data['added_by_id'] = $request->user()->id;
        //images uploaded
        if ($request->hasFile('barcode_image')){
            $data['barcode_image']=$this->uploadFiles('products',$request->file('barcode_image'),null);
        }
        if ($request->hasFile('image')){
            $data['image']=$this->uploadFiles('products',$request->file('image'),null);
        }
        //-----------------------------------
        $row->update($data);
        ProductCategory::where('product_id',$request->product_id)->delete();
        ProductCategory::updateOrCreate([
            'product_id' =>$request->product_id,
        ],[
            'category_id' =>$request->category_id,
        ]);
        return response()->json(['message'=>'new product had been updated'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Delete products
     */

    public function deleteProduct(Request $request)
    {
        $this->validate($request,[
            'product_id'=>'required|exists:products,id'
        ]);
        $row = Product::where([
            'id'=>$request->product_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();
        $row->delete();
        return response()->json(['message'=>'Product Had Deleted'],200);
    }//end function
    //
    public function addLocalBarcode(Request $request)
    {
        $this->validate($request,[
            'product_id'=>'required|exists:products,id',
            'local_barcode_code'=>'required',
            'local_barcode_image'=>'required|image'
        ]);
        $row = Product::findOrFail($request->product_id);
        $local_barcode_image = $this->uploadFiles('products',$request->file('local_barcode_image'),null);
        $row->update([
            'local_barcode_code'=>$request->local_barcode_code,
            'local_barcode_image'=>$local_barcode_image,
        ]);
        return response()->json(['message'=>'Product updated'],200);
    }//end function




}//end class
