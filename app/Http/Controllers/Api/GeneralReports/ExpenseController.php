<?php

namespace App\Http\Controllers\Api\GeneralReports;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiUserTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\ExpenseRevenue ;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {

    }

    // Detailed expense report
    public function detailedExpenseReport(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql  = ExpenseRevenue::where("user_id",$user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        if($search_name != "all" ){
            $sql = $sql->whereHas("expense_account",
                function ($query) use ($search_name) {
                $query->where("display_title", "like", "%" . $search_name . "%");
            });
        }
        $json = $sql->with("expense_account")->get();
        return response(['data' =>$json, "message" => "result data", "status" => 200], 200);
    }

    // An outline expense report
    public function outlineExpenseReport(Request $request){
        $search_name = ($request->search_name) ? $request->search_name : "all";
        $from_date = ($request->from_date) ? $request->from_date : "all";
        $to_date = ($request->to_date) ? $request->to_date : "all";
        $user_id = ($request->user_id) ? $request->user_id : "0";
        //---------------------------------------
        $sql  = ExpenseRevenue::select(DB::raw("*,SUM(total_price) as total"))
                                ->where("user_id",$user_id);
        if ($from_date != "all") {
            $sql = $sql->where("date", ">=", $from_date);
        }
        if ($to_date != "all") {
            $sql = $sql->where("date", "<=", $to_date);
        }
        if($search_name != "all" ){
            $sql = $sql->whereHas("expense_account",
                function ($query) use ($search_name) {
                    $query->where("display_title", "like", "%" . $search_name . "%");
                });
        }
        $json = $sql->with("expense_account")->groupBy("debtor_id")->get();
        return response(['data' =>$json, "message" => "result data", "status" => 200], 200);
    }

}