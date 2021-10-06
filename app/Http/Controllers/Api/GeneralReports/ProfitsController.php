<?php

namespace App\Http\Controllers\Api\GeneralReports;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class ProfitsController extends Controller
{
    // ProfitsController
    public function index()
    {

    }
    // Detailed earnings report
    public function detailedEarningsReport(Request $request)
    {
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $where = [
            ["sale_type", "=", "normal_sale"],
            ["user_id", "=", $user_id]
        ];
        if ($from_date != "all") {
            $where[2] = ["date", ">=", $from_date];
        }
        if ($to_date != "all") {
            $where[3] = ["date", "<=", $to_date];
        }
        //--------------------------------------
        $sql = SaleDetail::select(DB::raw("*,SUM(amount) as amount"))->whereHas("one_sale",
            function ($query) use ($where) {
                $query->where($where);
            });
        //--------------------------------------
        if ($search_name != "all") {
            $sql = $sql->whereHas("one_product",
                function ($query) use ($search_name) {
                    $query->where("title", "like", "%" . $search_name . "%");
                });
        }
        //--------------------------------------
        $bills = $sql->with(["one_sale","one_product"])->groupBy("product_id")->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    public function aggregateEarningsReport(Request $request){
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sqlPurchase = Purchase::where("purchase_type","normal_purchase")->where("user_id",$user_id);
        $sqlSale = Sale::where("sale_type","normal_sale")->where("user_id",$user_id);

        if ($from_date != "all") {
           $sqlPurchase = $sqlPurchase->where("date", ">=", $from_date) ;
           $sqlSale = $sqlSale->where("date", ">=", $from_date) ;
        }
        if ($to_date != "all") {
            $sqlPurchase = $sqlPurchase->where("date", "<=", $to_date) ;
            $sqlSale = $sqlSale->where("date", "<=", $to_date) ;
        }

        $purchase = $sqlPurchase->sum("total_price");
        $sale = $sqlSale->sum("total_price");
        $json["purchase"] = $purchase ;
        $json["sale"] = $sale;
        $json["profits"] = $sale - $purchase;
        return response(['data' => $json, "message" => "result data", "status" => 200], 200);
    }

}