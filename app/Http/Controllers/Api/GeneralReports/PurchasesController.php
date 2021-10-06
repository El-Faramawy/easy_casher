<?php

namespace App\Http\Controllers\Api\GeneralReports;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\PurchaseDetail;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function index()
    {

    }

    // detailedPurchaseReport
    public function detailedPurchaseReport(Request $request)
    {
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $where = [
            ["purchase_type", "=", "normal_purchase"],
            ["user_id", "=", $user_id]
        ];
        if ($from_date != "all") {
            $where[2] = ["date", ">=", $from_date];
        }
        if ($to_date != "all") {
            $where[3] = ["date", "<=", $to_date];
        }
        //--------------------------------------
        $sql = PurchaseDetail::whereHas("one_purchase",
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
        $bills = $sql->with(["one_purchase","one_product"])->get();

        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    //An aggregate purchase report
    public function anAggregatePurchaseReport(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $where = [
            ["purchase_type", "=", "normal_purchase"],
            ["user_id", "=", $user_id]
        ];
        if ($from_date != "all") {
            $where[2] = ["date", ">=", $from_date];
        }
        if ($to_date != "all") {
            $where[3] = ["date", "<=", $to_date];
        }
        //--------------------------------------
        $sql = PurchaseDetail::select(DB::raw("*,SUM(amount) as amount"))->whereHas("one_purchase",
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
        $bills = $sql->with(["one_purchase","one_product"])->groupBy("product_id")->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }

    // Report of unpaid purchases invoices
    public function reportOfUnpaidPurchasesInvoices(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //--------------------------------------------
        $sql = Purchase::where("purchase_type", "=", "normal_purchase")
            ->where("user_id", "=", $user_id)->where("remaining_price","!=",0);
        //--------------------------------------------
        if ($from_date != "all") {
            $sql = $sql->where("date",">=",$from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date","<=",$to_date);
        }
        if ($search_name != "all") {
            $sql = $sql->whereHas("supplier",
                function ($query) use ($search_name) {
                    $query->where("name", "like", "%" . $search_name . "%");
                });
        }
        //-------------------------------------------  client
        $bills = $sql->with(["supplier"])->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    // Purchase bills
    public function PurchaseInvoices(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //--------------------------------------------
        $sql = Purchase::where("purchase_type", "=", "normal_purchase")
            ->where("user_id", "=", $user_id);
        //--------------------------------------------
        if ($from_date != "all") {
            $sql = $sql->where("date",">=",$from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date","<=",$to_date);
        }
        if ($search_name != "all") {
            $sql = $sql->where("id",$search_name);
        }
        //-------------------------------------------
        $bills = $sql->with(["supplier"])->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }

}