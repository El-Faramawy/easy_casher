<?php

namespace App\Http\Controllers\Api\GeneralReports;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {

    }

    //---------------------------------------------

    // reportRemainingAmountsSuppliers
    public function reportRemainingAmountsSuppliers(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql = Purchase::select(DB::raw("remaining_price , supplier_id ,SUM(remaining_price) as total_remaining_price"))
                       ->where("purchase_type","normal_purchase")
                       ->where("user_id",$user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        if ($search_name != "all") {
            $sql = $sql->whereHas("supplier" , function ($query) use ($search_name) {
                $query->where("name", "like", "%" . $search_name . "%");
            });
        }
        //--------------------------------------
        $bills = $sql->with(["supplier"])->groupBy("supplier_id")->get();

        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    // Supplier invoices
    public function supplierInvoices(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $bill_num = ($request->bill_num) ? $request->bill_num : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql = Purchase::where("purchase_type","normal_purchase")->where("user_id",$user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        if ($bill_num != "all") {
            $sql = $sql->where("id", $bill_num);
        }
        if ($search_name != "all") {
            $sql = $sql->whereHas("supplier" , function ($query) use ($search_name) {
                $query->where("name", "like", "%" . $search_name . "%");
            });
        }
        //--------------------------------------
        $bills = $sql->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    // reportProductsPurchasedSupplier
    public function reportProductsPurchasedSupplier(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $product_name = ($request->product_name) ? $request->product_name : "all";
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
        if ($product_name != "all") {
            $sql = $sql->whereHas("one_product",
                function ($query) use ($product_name) {
                    $query->where("title", "like", "%" . $product_name . "%");
                });
        }
        //---------------------------------------
        if ($search_name != "all") {
            $sql = $sql->whereHas("purchase.supplier",
                function ($query) use ($search_name) {
                    $query->where("name", "like", "%" . $search_name . "%");
                });
        }
        //--------------------------------------
        $bills = $sql->with(["one_purchase","one_product"])->groupBy("product_id")->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }

}