<?php

namespace App\Http\Controllers\Api\reports;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalesReportController extends Controller
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
        //--------- today --------
        $today_sales = (Sale::where([
            'sale_type'=>'normal_sale',
            'user_id'=>$user->trader_id,
            'date'=>date('Y-m-d')
        ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                 'date'=>date('Y-m-d')
            ])->sum('total_price'));
        $data['today'] = $today_sales ;
        //-------- yesterday ---------
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $yesterday_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ])->sum('total_price'));
        $data['yesterday'] = $yesterday_sales ;
        //-------- this month ---------
        $saleThisMonth = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'))
                ->sum('total_price'));
        $data['saleThisMonth'] = $saleThisMonth;
        //-------- last month ---------
        $lastMonth_date = date('M Y', strtotime("-1 month"));
        $saleLastMonth = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)))
                ->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m',strtotime("-1 month")))
                ->sum('total_price'));
        $data['saleLastMonth'] = $saleLastMonth;
        //-------- all ---------
        $all_sales = (Sale::where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->sum('total_price')) -  (Sale::where([
                'sale_type'=>'back_sale',
                'user_id'=>$user->trader_id,
            ])->sum('total_price'));
        $data['all'] = $all_sales;

        return response()->json($data, 200);
    }//end function


    //        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
//        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
//
//        $saleLastMonth = (Sale::where([
//                'sale_type'=>'normal_sale',
//                'user_id'=>$user->trader_id,
//            ])->whereBetween('date', [$fromDate, $tillDate])
//                ->sum('total_price')) -  (Sale::where([
//                'sale_type'=>'back_sale',
//                'user_id'=>$user->trader_id,
//            ])->whereBetween('date', [$fromDate, $tillDate])
//                ->sum('total_price'));
//        $data['saleLastMonth'] = $saleLastMonth;


}//end class
