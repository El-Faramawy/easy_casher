<?php

namespace App\Http\Controllers\Api\Revenues;

use App\Http\Controllers\Controller;
use App\Models\ExpenseRevenue;
use Illuminate\Http\Request;

class ApiRevenueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'apiPermission:revenuesDepartment'])
            ->only([
                'allRevenues',
                'singleRevenue',
                'makeRevenue',
                'editRevenue',
                'deleteRevenue',
            ]);
    }//end construct


    public function allRevenues(Request $request)
    {
        $rows = ExpenseRevenue::where([
            'type' => 'revenues',
            'user_id' => $request->user()->trader_id,
        ])->get();
        return response()->json(['data' => $rows], 200);
    }//end fun

    public function singleRevenue(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:expense_revenues,id'
        ]);
        $row = ExpenseRevenue::where([
            'id' => $request->id,
            'type' => 'revenues',
            'user_id' => $request->user()->trader_id,
        ])->firstOrFail();
        return response()->json($row, 200);
    }//end fun


    public function makeRevenue(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|exists:accounts,id',
            'total_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'=>'required|date_format:Y-m-d',
        ]);


        $accountOfTrader = $request->user()->trader_account()->first();
        if (!$accountOfTrader) {
            return response()->json(['message' => 'Trader Account Balance not exists'], 406);
        }


        ExpenseRevenue::create([
            'type' => 'revenues',
            'user_id' => $request->user()->trader_id,
            'added_by_id' => $request->user()->id,
            'creditor_id' => $request->account_id,
            'debtor_id' => $accountOfTrader->id,
            'total_price' => $request->total_price,
            'date' => $request->date,
        ]);
        return response()->json(['message' => 'Successfully Created'], 200);

    }//end fun


    public function editRevenue(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:expense_revenues,id',
            'total_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'=>'required|date_format:Y-m-d',
        ]);
        $row = ExpenseRevenue::where([
            'id' => $request->id,
            'type' => 'revenues',
            'user_id' => $request->user()->trader_id,
        ])->firstOrFail();

        $row->update([
            'total_price' => $request->total_price,
            'date' => $request->date,
        ]);
        return response()->json(['message' => 'Successfully Updated'], 200);

    }//end fun

    public function deleteRevenue(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:expense_revenues,id',
        ]);
        $row = ExpenseRevenue::where([
            'id' => $request->id,
            'type' => 'revenues',
            'user_id' => $request->user()->trader_id,
        ])->firstOrFail();
        $row->delete();
        return response()->json(['message' => 'Successfully Deleted'], 200);
    }//end fun


}//end class
