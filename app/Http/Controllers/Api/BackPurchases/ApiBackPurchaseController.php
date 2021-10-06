<?php

namespace App\Http\Controllers\Api\BackPurchases;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiBackPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:backPurchasesDepartment'])
            ->only([
                'makePurchaseOrder',
                'purchaseOrders',
                'single_purchase_order',
                'deletePurchaseOrder',
            ]);
    }//end construct

    public function makePurchaseOrder(Request $request)
    {
        //validation
        $request->validate([
            'supplier_id'=>'required|exists:clients,id',
            'total_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'paid_price'=>'required|regex:/^\d+(\.\d{1,2,0})?$/',
            'remaining_price'=>'required|regex:/^\d+(\.\d{1,2,0})?$/',
            'date'=>'required|date_format:Y-m-d',
            'order_details'=>'required|array',
            'order_details.*'=>'required',
            'order_details.*.product_id'=>Rule::exists('products', 'id')->whereNull('deleted_at'),
            'order_details.*.amount'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'order_details.*.price_value'=>'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        //more client validation
        $client = Client::where([
            'id'=>$request->supplier_id,
            'client_type'=>'supplier',
            'user_id'=>$request->user()->trader_id,
        ])->first();
        if(!$client) return response()->json(['message'=>'Supplier not exists'],403);


        //check Accounts

        $accountOfClient = $client->account()->first();
        if (!$accountOfClient){
            return response()->json(['message'=>'Client Account Balance not exists'],405);
        }

        $accountOfTrader = $request->user()->trader_account()->first();
        if (!$accountOfTrader){
            return response()->json(['message'=>'Trader Account Balance not exists'],406);
        }


        $creditor_id = $accountOfClient->id;
        $debtor_id = $accountOfTrader->id;

        //make purchase order

        $purchase = Purchase::create([
            'purchase_type'=>'back_purchase',
            'user_id'=>$request->user()->trader_id,
            'supplier_id'=>$client->id,
            'creditor_id'=>$creditor_id,
            'debtor_id'=>$debtor_id,
            'total_price'=>$request->total_price,
            'paid_price'=>$request->paid_price,
            'remaining_price'=>$request->remaining_price,
            'date'=>$request->date,
            'added_by_id'=>$request->user()->id,
        ]);
        //purchase details
        foreach ($request->order_details as $row){
            $product = Product::findOrFail($row['product_id']);
            if ($product->stock_type == 'in_stock'){
                $product->stock_amount = $product->stock_amount-$row['amount'];
                $product->save();
            }
            PurchaseDetail::create([
                'purchase_id'=>$purchase->id,
                'product_id'=>$row['product_id'],
                'price_value'=>$row['price_value'],
                'amount'=>$row['amount'],
            ]);
        }

        return response()->json(['message'=>'Back purchase Order Has Created'],200);
    }//end fun


    public function purchaseOrders(Request $request)
    {
        $purchases =Purchase::where([
            'user_id'=>$request->user()->trader_id,
            'purchase_type'=>'back_purchase',
        ])->with([
            'trader',
            'supplier',
            'purchase_details.product.single_category',
            'purchase_details.product.color',
            'addedBy'
        ])->get();
        return response()->json(['data'=>$purchases],200);
    }//end fun

    public function single_purchase_order(Request $request)
    {
        $this->validate($request,[
            'back_purchase_id'=>'required|exists:purchases,id'
        ]);
        $row =  Purchase::where([
            'user_id'=>$request->user()->trader_id,
            'purchase_type'=>'back_purchase',
            'id'=>$request->back_purchase_id
        ])->with([
            'trader',
            'supplier',
            'purchase_details.product.single_category',
            'purchase_details.product.color',
            'addedBy'
        ])->firstOrFail();
        return response()->json($row,200);
    }//end fun


    public function deletePurchaseOrder(Request $request)
    {
        $this->validate($request,[
            'back_purchase_id'=>'required|exists:purchases,id'
        ]);
        $purchase = Purchase::where([
            'user_id'=>$request->user()->trader_id,
            'purchase_type'=>'back_purchase',
            'id'=>$request->back_purchase_id
        ])->firstOrFail();

        foreach ($purchase->purchase_details as $row){
            $product = Product::findOrFail($row->product_id);
            if ($product->stock_type == 'in_stock'){
                $product->stock_amount = $product->stock_amount+$row->amount;
                $product->save();
            }
        }
        $purchase->delete();
        return response()->json(['message'=>'Back purchase Order Had been Deleted'],200);
    }//end fun
}
