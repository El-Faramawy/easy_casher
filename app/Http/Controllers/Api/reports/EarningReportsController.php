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

class EarningReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'apiPermission:selectsAndReportDepartment'])
            ->only([
                'index'
            ]);
    }//end construct

    /**
     * @param Request $request
     * @return mixed
     *
     *
     */

    public function index(Request $request)
    {
        $user = $request->user();
        //--------- today --------
        $today_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')
                //revenues
                +
                ExpenseRevenue::where([
                    'type'=>'revenues',
                    'user_id'=>$user->trader_id,
                    'date'=>date('Y-m-d')
                ])->sum('total_price')
                //purchase back
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
                //expense
                +
                ExpenseRevenue::where([
                    'type'=>'expense',
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
        $data['today'] = $today_earnings ;
        //-------- yesterday ---------
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $yesterday_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')
                //revenues
                +
                ExpenseRevenue::where([
                    'type'=>'revenues',
                    'user_id'=>$user->trader_id,
                    'date'=>$yesterday
                ])->sum('total_price')
                //purchase back
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
                //expense
                +
                ExpenseRevenue::where([
                    'type'=>'expense',
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
        $data['yesterday'] = $yesterday_earnings;
        //-------- this month ---------
//        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
//        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $earningThisMonth =(
        //sales (normal)
        Sale::where([
            'sale_type'=>'normal_sale',
            'user_id'=>$user->trader_id,
        ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
            ->sum('total_price')
        //revenues
        +
        ExpenseRevenue::where([
            'type'=>'revenues',
            'user_id'=>$user->trader_id,
        ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
            ->sum('total_price')
        //purchase back
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
        //expense
        +
        ExpenseRevenue::where([
            'type'=>'expense',
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
        $data['earningThisMonth'] = $earningThisMonth;

        //-------- last month ---------
//        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
//        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $lastMonth_date = date('M Y', strtotime("-1 month"));
        $earningLastMonth =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')
                //revenues
                +
                ExpenseRevenue::where([
                    'type'=>'revenues',
                    'user_id'=>$user->trader_id,
                ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                    ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                    ->sum('total_price')
                //purchase back
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
                //expense
                +
                ExpenseRevenue::where([
                    'type'=>'expense',
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
        $data['earningLastMonth'] = $earningLastMonth;
        //------- all --------
        $all_earnings =(
                //sales (normal)
                Sale::where([
                    'sale_type'=>'normal_sale',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
                //revenues
                +
                ExpenseRevenue::where([
                    'type'=>'revenues',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
                //purchase back
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
                //expense
                +
                ExpenseRevenue::where([
                    'type'=>'expense',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
                //purchase (normal)
                +
                Purchase::where([
                    'purchase_type'=>'normal_purchase',
                    'user_id'=>$user->trader_id,
                ])->sum('total_price')
            );
        $data['all'] = $all_earnings ;

        return response()->json($data, 200);
    }//end function

}//end class
