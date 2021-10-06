<?php

namespace App\Http\Controllers\Api\GeneralReports;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Product;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {

    }

   /*
   public function storeInventory(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sqlProduct   = Product::select(DB::raw(""))->where("user_id",$user_id);
        $sqlPurchases = PurchaseDetail::select(DB::raw(""))->whereHas("one_purchase",
            function ($query) use ($user_id) {
                $query->where("user_id",$user_id);
            });
        if ($from_date != "all") {
            $sqlProduct = $sqlProduct->whereDate("created_at", ">=", $from_date);
            $sqlPurchases = $sqlPurchases->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sqlProduct = $sqlProduct->whereDate("created_at", "<=", $to_date);
            $sqlPurchases = $sqlPurchases->where("date", "<=", $to_date);
        }
        if($search_name != "all"){
            $sqlProduct = $sqlProduct->where("title", "like", "%" . $search_name . "%");
            $sqlPurchases = $sqlPurchases->whereHas("one_purchase",
                function ($query) use ($search_name) {
                    $query->where("title", "like", "%" . $search_name . "%");
            });
        }

   }
   */

    // The movement of the purchase price change for an item
    public function movementPurchasePriceChangeItem(Request $request){
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
        if ($search_name != "all") {
            $sql = $sql->whereHas("one_product",
                function ($query) use ($search_name) {
                    $query->where("title", "like", "%" . $search_name . "%");
                });
        }
        $bills = $sql->with("one_purchase")->get();
        return response(['data' => $bills, "message" => "result data", "status" => 200], 200);
    }

    

}