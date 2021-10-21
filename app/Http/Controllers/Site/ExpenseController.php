<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\ExpenseRevenue;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['apiPermission:expensesDepartment'])
//            ->only([
//                'allExpenses',
//                'singleExpense',
//                'makeExpense',
//                'editExpense',
//                'deleteExpense',
//            ]);
//    }//end construct

    public function allExpenses(Request $request)
    {
//        return auth()->user();
        $sliders = Slider::where('type','expenses')->get();
        $clients = Account::where([
                'user_id'=>auth()->user()->trader_id,
            ])->get();
        $rows = ExpenseRevenue::where([
            'type' => 'expense',
            'user_id' => auth()->user()->trader_id,
        ])->get();
//        return $rows;
        return view('Site.expenses',['datas' => $rows,'accounts' => $clients,'sliders' => $sliders]);
    }//end fun

    public function makeExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'account_id' => 'required|exists:accounts,id',
            'total_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'=>'required|date_format:Y-m-d',
        ],[
//            'account_id.required'=>'الحساب مطلوب',
            'total_price.required'=>'السعر مطلوب',
            'date.required'=>'التاريخ مطلوب',
        ]);
        if ($validator->fails()) return response()->json(['type'=>'error','message'=>$validator->errors()->getMessages()]);

        $accountOfTrader = $request->user()->trader_account()->first();
        if (!$accountOfTrader) {
            return response()->json(['message' => ['رصيد المستخدم غير موجود'],'type'=>'error']);
        }
        $account_id = 1;
        if ($request->name){
            $user_type =  $request->user()->id == $request->user()->trader_id ;
            $account_id = Account::create([
                'display_title' => $request->name,
                'model_id' => $request->user()->trader_id,
                'model_type' => 'App/Models/User',
                'user_id' => $request->user()->trader_id,
                'added_by_id' => $request->user()->id,
                'user_type' => $user_type,
            ]);
        }
//            $this->createAccount($request->name, $request->user()->trader_id, 'App/Models/User', $request->user()->trader_id, $request->user()->id);

        ExpenseRevenue::create([
            'type' => 'expense',
            'user_id' => $request->user()->trader_id,
            'added_by_id' => $request->user()->id,
            'creditor_id' => $accountOfTrader->id,
            'debtor_id' => $request->name?$account_id->id :$request->account_id,
            'total_price' => $request->total_price,
            'date' => $request->date,
        ]);
        return response()->json(['type' => 'success']);

    }//end fun


    public function editExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'=>'required|date_format:Y-m-d',
        ],[
            'total_price.required'=>'السعر مطلوب',
            'date.required'=>'التاريخ مطلوب',
        ]);
        if ($validator->fails()) return response()->json(['type'=>'error','message'=>$validator->errors()->getMessages()]);

        $accountOfTrader = $request->user()->trader_account()->first();
        if (!$accountOfTrader) {
            return response()->json(['message' => ['رصيد المستخدم غير موجود'],'type'=>'error']);
        }
        $account_id = 1;
        if ($request->name){
            $user_type =  $request->user()->id == $request->user()->trader_id ;
            $account_id = Account::create([
                'display_title' => $request->name,
                'model_id' => $request->user()->trader_id,
                'model_type' => 'App/Models/User',
                'user_id' => $request->user()->trader_id,
                'added_by_id' => $request->user()->id,
                'user_type' => $user_type,
            ]);
        }

        ExpenseRevenue::find($request->id)->update([
            'user_id' => $request->user()->trader_id,
            'added_by_id' => $request->user()->id,
            'creditor_id' => $accountOfTrader->id,
            'debtor_id' => $request->name?$account_id->id :$request->account_id,
            'total_price' => $request->total_price,
            'date' => $request->date,
        ]);
        return redirect()->back();

    }//end fun

}
