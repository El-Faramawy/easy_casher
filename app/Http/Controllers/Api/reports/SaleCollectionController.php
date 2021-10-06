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

class SaleCollectionController extends Controller
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
    }//end function

    /**
     * @param $user
     * @return mixed
     *
     * get collection of today
     *
     */
    public function today($user)
    {
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ])->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
            'date'=>date('Y-m-d')
        ])->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
       $data['rate_of_earnings'] =$total_sales > 0 ?
           round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
           : 0;

        return $data;
    }

    /**
     * @param $user
     *
     * yesterday
     */
    public function yesterday($user)
    {
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
            'date'=>$yesterday
        ])->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;
    }

    /**
     * @param $user
     *
     * last 7 days
     */
    public function last7days($user)
    {
        //->whereRaw('DATE(AppDate) = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
        $last_7_days = date('Y-m-d',strtotime("-7 days"));
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->whereDate('date','>=',$last_7_days)->whereDate('date','<=',date('Y-m-d'))
            ->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;
    }

    /**
     * @param $user
     *
     */

    public function this_month($user)
    {
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                    ->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                    ->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                    ->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                    ->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
            ->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;
    }



    public function last30days($user)
    {
        //->whereRaw('DATE(AppDate) = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
        $last_30_days = date('Y-m-d', strtotime('today - 30 days'));
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                ->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
                    ->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->whereDate('date','>=',$last_30_days)->whereDate('date','<=',date('Y-m-d'))
            ->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;

    }


    public function last_month($user)
    {
        $lastMonth_date = date('M Y', strtotime("-1 month"));
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
            ->whereMonth('date',date('m',strtotime($lastMonth_date)))
            ->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;
    }


    public function all($user)
    {
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;
    }

    public function custom($user , $from ,$to)
    {
        //-------- sales ----------------
        $total_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('total_price'));
        $data['total_sales'] = $total_sales ;

        //-------- discount_value ----------------

        $total_discount_value = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('discount_value')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,

            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('discount_value'));
        $data['total_discount_value'] = $total_discount_value ;
        //-------- all after discount ----------------

        $data['total_sales_after_discount'] = $total_sales - $total_discount_value ;

        //-------- paid value ----------------

        $total_paid_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('paid_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('paid_price'));
        $data['total_paid_price'] = $total_paid_price ;

        //-------- remaining value ----------------

        $total_remaining_price = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('remaining_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                ->sum('remaining_price'));
        $data['total_remaining_price'] = $total_remaining_price ;

        //-------------- earnings -----------------------------
        $total_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                    ->sum('total_price')
                //revenues
                +
                Purchase::where([
                    'purchase_type'=>'back_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                    ->sum('total_price')

            ) - (
                //sales (back)
                Sale::where([
                    'sale_type'=>'back_sale',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                    ->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
                    ->sum('total_price')
            );
        $data['total_earnings'] = $total_earnings ;
        //------------- expense -----------------------
        $total_expense = ExpenseRevenue::where([
            'type'=>'expense',
            'user_id'=>$user->trader_id,
        ])->whereDate('date','>=',$from)->whereDate('date','<=',$to)
            ->sum('total_price');
        $data['total_expense'] = $total_expense ;
        //------------- total earnings after expense -----------------------

        $data['total_earnings_after_expense'] = $total_earnings -$total_expense ;
        //------------- rate of earnings -----------------------
        $data['rate_of_earnings'] =$total_sales > 0 ?
            round((($total_earnings -$total_expense) / $total_sales) * 100, 2)
            : 0;

        return $data;

    }


}//end class
