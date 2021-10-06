<?php

namespace App\Http\Controllers\Api\reports;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ExpenseRevenue;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'apiPermission:selectsAndReportDepartment'])
            ->only([
                'index'
            ]);
    }//end construct



    public function index(Request $request)
    {
        $user = $request->user();
        $this->validate($request,[
            'type'=>'required|in:today,yesterday,last7days,this_month,last30days,last_month,all,custom',
        ]);
        if ($request->type =='custom'){
            $this->validate($request,[
                'from'=>'required|date|date_format:Y-m-d',
                'to'=>'required|date|date_format:Y-m-d|after_or_equal:from',
            ]);
            return response()->json($this->{$request->type}($user,$request->from,$request->to), 200);

        }
        return response()->json($this->{$request->type}($user), 200);
    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * get collection of today
     *
     */
    public function today($user)
    {
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * yesterday
     */
    public function yesterday($user)
    {
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;

    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * last7days
     */
    public function last7days($user)
    {
        $last_7_days = date('Y-m-d',strtotime("-7 days"));
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * current month
     */
    public function this_month($user)
    {
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun


    /**
     * @param $user
     * @return mixed
     *
     * 30 days
     */
    public function last30days($user)
    {

        $last_30_days = date('Y-m-d', strtotime('today - 30 days'));
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * last month
     */
    public function last_month($user)
    {
        $lastMonth_date = date('M Y', strtotime("-1 month"));

        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun

    /**
     * @param $user
     * @return mixed
     *
     * all
     */
    public function all($user)
    {
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;
    }//end fun
    /**
     * @param $user
     * @return mixed
     *
     * custom
     */
    public function custom($user , $from ,$to)
    {
        //total
        $total_purchase =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('total_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('total_price');
        $data['total_purchase'] = $total_purchase;

        //paid
        $total_purchase_paid =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('paid_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('paid_price');
        $data['total_paid_purchase'] = $total_purchase_paid;

        //remaining
        $total_purchase_remaining_price =  Purchase::where([
                'purchase_type'=>'back_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('remaining_price') - Purchase::where([
                'purchase_type'=>'normal_purchase',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('remaining_price');
        $data['total_remaining_purchase'] = $total_purchase_remaining_price;
        return $data;

    }//end fun


}//end class
