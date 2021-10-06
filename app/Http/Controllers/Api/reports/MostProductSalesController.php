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

class MostProductSalesController extends Controller
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
        $data['today'] = $this->product_of_today($user);
        $data['yesterday'] = $this->product_of_yesterday($user);
        $data['this_month'] = $this->product_of_this_month($user);
        $data['last_month'] = $this->product_of_last_month($user);
        $data['all'] = $this->product_of_all($user);

       return response()->json($data,200);
    }//end function

    /**
     * @param $user
     * @return array
     *
     * Today Products
     */

    public function product_of_today($user)
    {
        //first q
        $today_sales = SaleDetail::whereHas('sale',function ($query) use ($user){
            $query->where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>date('Y-m-d')
            ]);
        })->get();
        if (count($today_sales)>0){
            //remove duplicated in products
            $collection_today = collect([]);
            $today_sales->each(function ($item) use ($collection_today) {
                $target = $collection_today->where('product_id', $item->product_id);
                if ($target->count() == 0)
                    $collection_today->push($item); // If it hasn't been added, add it to the collection
                else
                    $target->first()->product_amount += $item->amount;
            });
            //get total sales after subtracting back products
            foreach($collection_today as $sale_row_today){
                $product_amount =  $sale_row_today->product_amount;
                $sale_row_today->product_amount = $product_amount - SaleDetail::where('product_id',$sale_row_today->product_id)
                        ->whereHas('sale',function ($query) use ($user){
                            $query->where([
                                'sale_type'=>'back_sale',
                                'user_id'=>$user->trader_id,
                                'date'=>date('Y-m-d')
                            ]);
                        })->sum('amount');
            }
            //arrange the collection
            $collection_today = collect($collection_today)
                ->take(5)
                ->sortByDesc('product_amount');
            //get products
            $products_today = [];
            if (count($collection_today)>0){
                foreach ($collection_today as $collection_today_one){
                    $single =  Product::where([
                        'id'=>$collection_today_one->product_id ,
                    ])->with('single_category')
                        ->first();

                    if ($single != null)
                    {
                        $single->product_amount =$collection_today_one->product_amount;
                        $products_today[] =$single;
                    }
                }
            }
            return $products_today;
        }
        return collect([]);

    }//end function of today

    /**
     * @param $user
     * @return array
     *
     * yesterday Products
     */
    public function product_of_yesterday($user)
    {
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        //first q
        $yesterday_sales = SaleDetail::whereHas('sale',function ($query) use ($user,$yesterday){
            $query->where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
                'date'=>$yesterday
            ]);
        })->get();
        if (count($yesterday_sales)>0){
            //remove duplicated in products
            $collection_yesterday = collect([]);
            $yesterday_sales->each(function ($item) use ($collection_yesterday) {
                $target = $collection_yesterday->where('product_id', $item->product_id);
                if ($target->count() == 0)
                    $collection_yesterday->push($item); // If it hasn't been added, add it to the collection
                else
                    $target->first()->product_amount += $item->amount;
            });
            //get total sales after subtracting back products
            foreach($collection_yesterday as $sale_row_yesterday){
                $product_amount =  $sale_row_yesterday->product_amount;
                $sale_row_yesterday->product_amount = $product_amount - SaleDetail::where('product_id',$sale_row_yesterday->product_id)
                        ->whereHas('sale',function ($query) use ($user,$yesterday){
                            $query->where([
                                'sale_type'=>'back_sale',
                                'user_id'=>$user->trader_id,
                                'date'=>$yesterday
                            ]);
                        })->sum('amount');
            }
            //arrange the collection
            $collection_yesterday = collect($collection_yesterday)
                ->take(5)
                ->sortByDesc('product_amount');
            //get products
            $products_yesterday = [];
            if (count($collection_yesterday)>0){
                foreach ($collection_yesterday as $collection_yesterday_one){
                    $single =  Product::where([
                        'id'=>$collection_yesterday_one->product_id ,
                    ])->with('single_category')
                        ->first();

                    if ($single != null)
                    {
                        $single->product_amount =$collection_yesterday_one->product_amount;
                        $products_yesterday[] =$single;
                    }
                }
            }
            return $products_yesterday;
        }
        return collect([]);

    }//end function of yesterday

    /**
     * @param $user
     * @return array
     *
     * this Products
     */
    public function product_of_this_month($user)
    {
        //first q
        $month_sales = SaleDetail::whereHas('sale',function ($query) use ($user){
            $query->where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'));
        })->get();
        if (count($month_sales)>0){
            //remove duplicated in products
            $collection_month = collect([]);
            $month_sales->each(function ($item) use ($collection_month) {
                $target = $collection_month->where('product_id', $item->product_id);
                if ($target->count() == 0)
                    $collection_month->push($item); // If it hasn't been added, add it to the collection
                else
                    $target->first()->product_amount += $item->amount;
            });
            //get total sales after subtracting back products
            foreach($collection_month as $sale_row_month){
                $product_amount =  $sale_row_month->product_amount;
                $sale_row_month->product_amount = $product_amount - SaleDetail::where('product_id',$sale_row_month->product_id)
                        ->whereHas('sale',function ($query) use ($user){
                            $query->where([
                                'sale_type'=>'back_sale',
                                'user_id'=>$user->trader_id,
                            ])->whereYear('date',date('Y'))->whereMonth('date',date('m'));
                        })->sum('amount');
            }
            //arrange the collection
            $collection_month = collect($collection_month)
                ->take(5)
                ->sortByDesc('product_amount');

            //get products
            $products_month = [];
            if (count($collection_month)>0){

                foreach ($collection_month as $collection_month_one){
                    $single =  Product::where([
                        'id'=>$collection_month_one->product_id ,
                    ])->with('single_category')->first();
                    if ($single != null)
                    {
                        $single->product_amount = $collection_month_one->product_amount;
                        $products_month[] =$single;
                    }

                }
            }
            return $products_month;
        }
        return collect([]);

    }//end function of month

    /**
     * @param $user
     * @return array
     *
     * last Products
     */
    public function product_of_last_month($user)
    {
        $lastMonth_date = date('M Y', strtotime("-1 month"));
        //first q
        $month_sales = SaleDetail::whereHas('sale',function ($query) use ($user,$lastMonth_date){
            $query->where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                ->whereMonth('date',date('m',strtotime($lastMonth_date)));
        })->get();
        if (count($month_sales)>0){
            //remove duplicated in products
            $collection_month = collect([]);
            $month_sales->each(function ($item) use ($collection_month) {
                $target = $collection_month->where('product_id', $item->product_id);
                if ($target->count() == 0)
                    $collection_month->push($item); // If it hasn't been added, add it to the collection
                else
                    $target->first()->product_amount += $item->amount;
            });
            //get total sales after subtracting back products
            foreach($collection_month as $sale_row_month){
                $product_amount =  $sale_row_month->product_amount;
                $sale_row_month->product_amount = $product_amount - SaleDetail::where('product_id',$sale_row_month->product_id)
                        ->whereHas('sale',function ($query) use ($user,$lastMonth_date){
                            $query->where([
                                'sale_type'=>'back_sale',
                                'user_id'=>$user->trader_id,
                            ])->whereYear('date',date('Y',strtotime($lastMonth_date)))
                                ->whereMonth('date',date('m',strtotime($lastMonth_date)));
                        })->sum('amount');
            }
            //arrange the collection
            $collection_month = collect($collection_month)
                ->take(5)
                ->sortByDesc('product_amount');

            //get products
            $products_month = [];
            if (count($collection_month)>0){

                foreach ($collection_month as $collection_month_one){
                    $single =  Product::where([
                        'id'=>$collection_month_one->product_id ,
                    ])->with('single_category')->first();
                    if ($single != null)
                    {
                        $single->product_amount = $collection_month_one->product_amount;
                        $products_month[] =$single;
                    }

                }
            }
            return $products_month;
        }
        return collect([]);

    }//end function of last month

    /**
     * @param $user
     * @return array
     *
     * all Products
     */

    public function product_of_all($user)
    {
        //first q
        $all_sales = SaleDetail::whereHas('sale',function ($query) use ($user){
            $query->where([
                'sale_type'=>'normal_sale',
                'user_id'=>$user->trader_id,
            ]);
        })->get();
        if (count($all_sales)>0){
            //remove duplicated in products
            $collection_all = collect([]);
            $all_sales->each(function ($item) use ($collection_all) {
                $target = $collection_all->where('product_id', $item->product_id);
                if ($target->count() == 0)
                    $collection_all->push($item); // If it hasn't been added, add it to the collection
                else
                    $target->first()->product_amount += $item->amount;
            });
            //get total sales after subtracting back products
            foreach($collection_all as $sale_row_all){
                $product_amount =  $sale_row_all->product_amount;
                $sale_row_all->product_amount = $product_amount - SaleDetail::where('product_id',$sale_row_all->product_id)
                        ->whereHas('sale',function ($query) use ($user){
                            $query->where([
                                'sale_type'=>'back_sale',
                                'user_id'=>$user->trader_id,
                            ]);
                        })->sum('amount');
            }
            //arrange the collection
            $collection_all = collect($collection_all)
                ->take(5)
                ->sortByDesc('product_amount');

            //get products
            $products_all = [];
            if (count($collection_all)>0){

                foreach ($collection_all as $collection_all_one){
                    $single =  Product::where([
                        'id'=>$collection_all_one->product_id ,
                    ])->with('single_category')->first();
                    if ($single != null)
                    {
                        $single->product_amount = $collection_all_one->product_amount;
                        $products_all[] =$single;
                    }

                }
            }
            return $products_all;
        }
        return collect([]);

    }//end function of all
}//end class
