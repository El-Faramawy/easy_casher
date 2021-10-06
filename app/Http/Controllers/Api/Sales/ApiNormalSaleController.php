<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiNormalSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'apiPermission:salesDepartment'])
            ->only([
                'makeSaleOrder',
                'saleOrders',
                'single_sale_order',
                'deleteSaleOrder',
            ]);
    }//end construct

    public function makeSaleOrder(Request $request)
    {
        //validation
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'coupon_id' => 'exists:coupons,id|nullable',
            'total_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'paid_price' => 'required|regex:/^\d+(\.\d{1,2,0})?$/',
            'remaining_price' => 'required|regex:/^\d+(\.\d{1,2,0})?$/',
            'discount_value' => 'required|regex:/^\d+(\.\d{1,2,0})?$/',
            'date' => 'required|date_format:Y-m-d',
            'order_details' => 'required|array',
            'order_details.*' => 'required',
            'order_details.*.product_id' => Rule::exists('products', 'id')->whereNull('deleted_at'),
            'order_details.*.amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'order_details.*.price_value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        //more client validation
        $client = Client::where([
            'id' => $request->client_id,
            'client_type' => 'client',
            'user_id' => $request->user()->trader_id,
        ])->first();
        if (!$client) return response()->json(['message' => 'Client not exists'], 403);

        //more coupon validation
        if ($request->has('coupon_id')) {
            $coupon = Coupon::where([
                'id' => $request->coupon_id,
                'user_id' => $request->user()->trader_id,
            ])->first();
            if (!$coupon) return response()->json(['message' => 'Coupon not exists'], 404);
        }

        //check Accounts

        $accountOfClient = $client->account()->first();
        if (!$accountOfClient) {
            return response()->json(['message' => 'Client Account Balance not exists'], 405);
        }

        $accountOfTrader = $request->user()->trader_account()->first();
        if (!$accountOfTrader) {
            return response()->json(['message' => 'Trader Account Balance not exists'], 406);
        }


        $creditor_id = $accountOfClient->id;
        $debtor_id = $accountOfTrader->id;

        //make sale order

        $sale = Sale::create([
            'sale_type' => 'normal_sale',
            'user_id' => $request->user()->trader_id,
            'client_id' => $client->id,
            'creditor_id' => $creditor_id,
            'debtor_id' => $debtor_id,
            'coupon_id' => $request->coupon_id,
            'total_price' => $request->total_price,
            'paid_price' => $request->paid_price,
            'remaining_price' => $request->remaining_price,
            'discount_value' => $request->discount_value,
            'date' => $request->date,
            'added_by_id' => $request->user()->id,
        ]);
        //sale details
        foreach ($request->order_details as $row) {
            $product = Product::findOrFail($row['product_id']);
            if ($product->stock_type == 'in_stock') {
                $product->stock_amount = $product->stock_amount - $row['amount'];
                $product->save();
            }
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $row['product_id'],
                'price_value' => $row['price_value'],
                'amount' => $row['amount'],
            ]);
        }

        return response()->json($sale, 200);
    }//end fun


    public function saleOrders(Request $request)
    {
        $sales = Sale::where([
            'user_id' => $request->user()->trader_id,
            'sale_type' => 'normal_sale',
        ])->with([
            'trader',
            'client',
            'coupon',
            'sale_details.product.single_category',
            'sale_details.product.color',
            'addedBy'
        ])->get();
        return response()->json(['data' => $sales], 200);
    }//end fun

    public function single_sale_order(Request $request)
    {
        $this->validate($request, [
            'sale_id' => 'required|exists:sales,id'
        ]);
        $row = Sale::where([
            'user_id' => $request->user()->trader_id,
            'sale_type' => 'normal_sale',
            'id' => $request->sale_id
        ])->with([
            'trader',
            'client',
            'coupon',
            'sale_details.product.single_category',
            'sale_details.product.color',
            'addedBy'
        ])->firstOrFail();
        return response()->json($row, 200);
    }//end fun


    public function deleteSaleOrder(Request $request)
    {
        $this->validate($request, [
            'sale_id' => 'required|exists:sales,id'
        ]);
        $sale = Sale::where([
            'id' => $request->sale_id,
            'user_id' => $request->user()->trader_id,
            'sale_type' => 'normal_sale',
        ])->firstOrFail();

        foreach ($sale->sale_details as $row) {
            $product = Product::findOrFail($row->product_id);
            if ($product->stock_type == 'in_stock') {
                $product->stock_amount = $product->stock_amount + $row->amount;
                $product->save();
            }

        }
        Sale::destroy($request->sale_id);
        return response()->json(['message' => 'Normal Sale Order Had been Deleted'], 200);
    }//end fun
}//end class
