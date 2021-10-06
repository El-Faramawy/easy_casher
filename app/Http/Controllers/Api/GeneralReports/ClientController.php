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
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {

    }

    // Report of the remaining amounts at customers
    public function reportAemainingAmountsCustomers(Request $request)
    {
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql = Sale::select(DB::raw("remaining_price , client_id ,SUM(remaining_price) as total_remaining_price"))
                   ->where("sale_type", "=", "normal_sale")
                   ->where("user_id", "=", $user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        //--------------------------------------
        if ($search_name != "all") {
            $sql = $sql->whereHas("client",
                function ($query) use ($search_name) {
                    $query->where("name", "like", "%" . $search_name . "%");
                });
        }
        //--------------------------------------
        $bills = $sql->with(["client"])->groupBy("client_id")->get();

        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);

    }

    public function clientBills(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $bill_num = ($request->bill_num) ? $request->bill_num : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql = Sale::where("sale_type", "=", "normal_sale")->where("user_id", "=", $user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        if ($bill_num != "all") {
            $sql = $sql->where("id", $bill_num);
        }
        //--------------------------------------
        if ($search_name != "all") {
            $sql = $sql->whereHas("client",
                function ($query) use ($search_name) {
                    $query->where("name", "like", "%" . $search_name . "%");
                });
        }
        //--------------------------------------
        $bills = $sql->get();

        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }

    // A report of the products sold to the customer
    public function reportProductsSoldCustomer(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $product_name = ($request->product_name) ? $request->product_name : "all";
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
        if ($product_name != "all") {
            $sql = $sql->whereHas("one_product",
                function ($query) use ($product_name) {
                    $query->where("title", "like", "%" . $product_name . "%");
                });
        }
        //---------------------------------------
        if ($search_name != "all") {
            $sql = $sql->whereHas("sale.client",
                function ($query) use ($search_name) {
                    $query->where("name", "like", "%" . $search_name . "%");
                });
        }
        //--------------------------------------
        $bills = $sql->with(["one_sale","one_product"])->groupBy("product_id")->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }


}