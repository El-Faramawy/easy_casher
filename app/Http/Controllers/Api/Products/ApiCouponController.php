<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Coupon;
use Illuminate\Http\Request;

class ApiCouponController extends Controller
{
    use Upload_Files;

    /**
     * ApiCouponController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:productsDepartment'])
            ->only([
                'searchCoupons',
                'getSingleCoupon',
                'addNewCoupon',
                'editCoupon',
                'deleteCoupon',
            ]);
    }//end construct

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search Coupons
     */
    public function searchCoupons(Request $request)
    {
        $this->validate($request,[
            'search_keyWord'=>'nullable'
        ]);
        $rows = Coupon::SearchCoupon($request->search_keyWord)
            ->where('user_id',$request->user()->trader_id)
            ->get();
        return response()->json(['data'=>$rows],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Get Single Coupon
     *
     */
    public function getSingleCoupon(Request $request)
    {
        $this->validate($request,[
            'coupon_id'=>'required|exists:coupons,id'
        ]);
        return response()->json(
            Coupon::where([
                'id'=>$request->coupon_id ,
                'user_id'=>$request->user()->trader_id
            ])->firstOrFail(),
            200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new coupon
     */

    public function addNewCoupon(Request $request)
    {
         $data = $this->validate($request,[
            'title'=>'required',
            'type'=>'required|in:pre,value',
            'value'=>"required|regex:/^\d+(\.\d{1,2})?$/",
        ]);
       /* if ($request->type == 'pre'){
            $this->validate($request,[
                'value'=>'gte:100'
            ]);
        }*/
        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        Coupon::create($data);
        return response()->json(['message'=>'new Coupon had been created'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Edit Coupon
     *
     */

    public function editCoupon(Request $request)
    {
        $request->validate([
            'coupon_id'=>'required|exists:coupons,id',
        ]);
        $data = $this->validate($request,[
            'title'=>'required',
            'type'=>'required|in:pre,value',
            'value'=>"required|regex:/^\d+(\.\d{1,2})?$/",
        ]);
        if ($request->type == 'pre'){
            $this->validate($request,[
                'value'=>'max:100'
            ]);
        }
        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        $row = Coupon::where([
            'id'=>$request->coupon_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();
        $row->update($data);
        return response()->json(['message'=>' Coupon had been updated'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Delete Coupon
     */

    public function deleteCoupon(Request $request)
    {
        $this->validate($request,[
            'coupon_id'=>'required|exists:coupons,id'
        ]);
        $row = Coupon::where([
            'id'=>$request->coupon_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();
        $row->delete();
        return response()->json(['message'=>'Coupon Had Deleted'],200);
    }//end function


}//end class
