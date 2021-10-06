<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Controller;
use App\Http\Traits\ForCashier\AccountCreating;
use App\Http\Traits\Upload_Files;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiClientController extends Controller
{
    use Upload_Files , AccountCreating;

    /**
     * ApiClientController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth:api','apiPermission:clientsDepartment'])
            ->only([
                'searchClients',
                'getSingleClient',
                'addNewClient',
                'editClient',
                'deleteClient',
            ]);
    }//end construct

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Search Client
     */
    public function searchClients(Request $request)
    {
        $this->validate($request,[
            'search_keyWord'=>'nullable'
        ]);
        $rows = Client::SearchClient($request->search_keyWord)
            ->where([
                'user_id'=>$request->user()->trader_id,
                'client_type'=>'client'
            ])
            ->get();
        return response()->json(['data'=>$rows],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Get Single Client
     *
     */
    public function getSingleClient(Request $request)
    {
        $this->validate($request,[
            'client_id'=>'required|exists:clients,id'
        ]);
        return response()->json(
            Client::where([
                'id'=>$request->client_id ,
                'user_id'=>$request->user()->trader_id
            ])->firstOrFail(),
            200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Add new Client
     */

    public function addNewClient(Request $request)
    {
        $data = $this->validate($request,[
            'name'=>'required',
            'email'=>'nullable',
            'phone_code'=>'nullable',
            'phone'=>'required',
            'address'=>'nullable',
            'notes'=>'nullable',

        ]);
        if ($request->email){
            //check email exist or not
            $type = 'email';
            $email_check = $this->check_if_email_or_phone_exist($type);
            if ($email_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$email_check);

        }

        //check phone exist or not
        $type = 'phone';
        $phone_check =$this->check_if_email_or_phone_exist($type);
        if ($phone_check != 200) return response()->json(['message'=>"the {$type} is already taken"],$phone_check);


        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        $data['client_type'] = 'client';
        $client = Client::create($data);
        //add balance
        $this->createAccount( $client->name ,$client->id ,'App/Models/Client' ,$request->user()->trader_id , $request->user()->id);

        return response()->json(['message'=>'new Client had been created'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Edit Client
     *
     */

    public function editClient(Request $request)
    {
        //validation
        $request->validate([
            'client_id'=>'required|exists:clients,id',
        ]);
        $data = $this->validate($request,[
            'name'=>'required',
            'email'=>Rule::unique('clients')->ignore($request->client_id),
            'phone_code'=>'nullable',
            'phone'=>Rule::unique('clients')->ignore($request->client_id),
            'address'=>'nullable',
            'notes'=>'nullable',

        ]);
        $row = Client::where([
            'id'=>$request->client_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();

        //update
        $data['user_id'] = $request->user()->trader_id;
        $data['added_by_id'] = $request->user()->id;
        $row->update($data);
        //update account
        $row->account()->update([
            'display_title' =>$request->name
        ]);
        return response()->json(['message'=>' Client had been updated'],200);
    }//end function


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Delete Client
     */

    public function deleteClient(Request $request)
    {
        $this->validate($request,[
            'client_id'=>'required|exists:clients,id'
        ]);
        $row = Client::where([
            'id'=>$request->client_id ,
            'user_id'=>$request->user()->trader_id
        ])->firstOrFail();
        $row->account()->delete();
        $row->delete();
        return response()->json(['message'=>'Client Had Deleted'],200);
    }//end function


    /*===============================================================*/
    /*===============================================================*/
    /*=======================    Helper    ==========================*/
    /*===============================================================*/
    /*===============================================================*/

    public function check_if_email_or_phone_exist($type)
    {
        $input[$type] = \request()->$type;
        $rules = array("{$type}" => "unique:clients,{$type}");
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            if ($type == 'email'){
                return 403;
            }else
                return 402;
        }
        return 200;
    }


}//end class
