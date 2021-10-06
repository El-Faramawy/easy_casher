<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayBillApi extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth:api', 'apiPermission:salesDepartment']);
    }
    
    public function index(Request $request)
    {
        $data = [];
        
        //validation
        $validator = Validator::make($request->all(), [
            'id'     => 'required|exists:sales,id',
            'amount' => 'required'
        ], 
        [
            'id.exists' => 'الفاتورة غير موجودة',
            'id.required' => 'رقم الفاتورة مطلوب',
            'amount.required' => 'المبلغ المسدد مطلوب'
        ]);
        
        if ($validator->fails())
        {
            // The given data did not pass validation
            $status = 422;
            $msg    = $validator->messages();
        }
        else
        {
            //validate amount 
            $sale_data = Sale::with(['sale_details.one_product',"one_client"])->find($request->id);
            //return $sale_data; 
            
            if($request->amount > $sale_data->remaining_price)
            {
                //return validation error
                $status = 201;
                $msg    = 'المبلغ المدفوع أكبر من المبلغ المتبقى';
                
            }
            else{
                //update sale data
                $sale_data->update([
                    'paid_price'      => $sale_data->paid_price + $request->amount,
                    'remaining_price' => $sale_data->remaining_price - $request->amount
                ]);
                
                $status = 200;
                $msg    = 'تم التحديث بنجاح';
                $data   = $sale_data;
            }
            
        }
        
        $output = [
                'data'    => $data,
                'message' => $msg, 
                'status'  => $status
            ];
            
        return response()->json($output, $status);
    }
}