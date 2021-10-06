<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{

    use Upload_Files;

    /**
     * ApiCategoryController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:productsDepartment'])
            ->only([
                'searchCategories',
                'getSingleCategory',
                'addNewCategory',
                'editCategory',
                'deleteCategory',
                'add_products_to_category'
            ]);
    }//end construct

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search Categories
     */
    public function searchCategories(Request $request)
    {
        $this->validate($request,[
            'search_keyWord'=>'nullable'
        ]);
        $categories = Category::SearchCategory($request->search_keyWord)
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
     * Get Single Category
     *
     */
    public function getSingleCategory(Request $request)
    {
        $this->validate($request,[
            'category_id'=>'required|exists:categories,id'
        ]);
        return response()->json(
            Category::where([
                'id'=>$request->category_id ,
                'user_id'=>$request->user()->trader_id
            ])->withCount('products')
                ->firstOrFail(),
            200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new Category
     */

    public function addNewCategory(Request $request)
    {
        $request->validate([
            'display_logo_type'=>'required|in:image,color',
        ]);
        $image_validate = $request->display_logo_type == 'image' ?'required':'nullable';
        $color_validate = $request->display_logo_type != 'image' ?'required|exists:colors,id':'nullable';
        $data = $this->validate($request,[
            'title'=>'required',
            'display_logo_type'=>'required|in:image,color',
            'image'=>"{$image_validate}|image|mimes:jpeg,jpg,png,gif|max:10000",
            'color_id'=>"{$color_validate}",
        ]);
        if ($request->hasFile('image')){
            $data['image']=$this->uploadFiles('categories',$request->file('image'),null);
        }else{
            $data['image']= $this->createImageFromTextManual('categories' , $request->title , 256 , '#000', '#fff');
        }
        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        Category::create($data);
        return response()->json(['message'=>'new category had been created'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Edit Categories
     *
     */

    public function editCategory(Request $request)
    {
        $request->validate([
            'category_id'=>'required|exists:categories,id',
            'display_logo_type'=>'required|in:image,color',
        ]);
        $image_validate = $request->display_logo_type == 'image' ?'required':'nullable';
        $color_validate = $request->display_logo_type != 'image' ?'required|exists:colors,id':'nullable';
        $data = $this->validate($request,[
            'title'=>'required',
            'image'=>"{$image_validate}|image|mimes:jpeg,jpg,png,gif|max:10000",
            'color_id'=>"{$color_validate}",
        ]);
        if ($request->hasFile('image')){
            $data['image']=$this->uploadFiles('categories',$request->file('image'),null);
        }else{
            $data['image']= $this->createImageFromTextManual('categories' , $request->title , 256 , '#000', '#fff');
        }
        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        $category = Category::where([
            'id'=>$request->category_id ,
            'user_id'=>$request->user()->trader_id
             ])->firstOrFail();
        $category->update($data);
        return response()->json(['message'=>' category had been updated'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Delete Category
     */

    public function deleteCategory(Request $request)
    {
        $this->validate($request,[
            'category_id'=>'required|exists:categories,id'
        ]);
        $category = Category::where([
            'id'=>$request->category_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();
        $category->delete();
        return response()->json(['message'=>'Category Had Deleted'],200);
    }//end function


    public function add_products_to_category(Request $request)
    {
        $request->validate([
            'category_id'=>'required|exists:categories,id',
            'products'=>'required|array',
            'products.*'=>'required|exists:products,id'
        ]);
        foreach ($request->products as $product_id){
            ProductCategory::updateOrCreate([
                'category_id'=>$request->category_id,
                'product_id'=>$product_id,
            ]);
        }
        return response()->json(['message'=>'products had added to this category'],200);
    }



}//end class
