<?php

namespace App\Http\Controllers\Api\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Models\Account;
use Illuminate\Http\Request;

class ApiAccountController extends Controller
{
    use AccountCreating;

    public function __construct()
    {
        $this->middleware(['auth:api'])
            ->only([
                'allAccounts',
                'singleAccount',
                'makeAccount',
                'editAccount',
                'deleteAccount',
            ]);
    }//end construct

    public function allAccounts(Request $request)
    {
        $accounts = Account::where([
            'user_id' => $request->user()->trader_id,
            'user_type' => 'parent',
        ])->get();
        return response()->json(['data' => $accounts], 200);
    }//end fun

    public function singleAccount(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|exists:accounts,id'
        ]);
        $account = Account::where('id', $request->account_id)->firstOrFail();
        return response($account, 200);
    }//end fun


    public function makeAccount(Request $request)
    {
        $data = $this->validate($request, [
            'display_title' => 'required'
        ]);
        $this->createAccount($request->display_title, $request->user()->trader_id, 'App/Models/User', $request->user()->trader_id, $request->user()->id);
        return response(['message' => 'Account Created Successfully'], 200);
    }//end fun


    public function editAccount(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|exists:accounts,id',
            'display_title' => 'required'
        ]);
        $account = Account::where('id', $request->account_id)->firstOrFail();
        $account->update([
            'display_title' => $request->display_title
        ]);
        return response(['message' => 'Account Updated Successfully'], 200);

    }//end fun

    public function deleteAccount(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|exists:accounts,id',
        ]);
        $account = Account::where('id', $request->account_id)->firstOrFail();
        $account->delete();
        return response(['message' => 'Account Had Been Deleted Successfully'], 200);

    }//end fun


}//end class
