<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     */
    public function contact_us(ContactRequest $request)
    {

        $data=$request->all();
        Contact::create($data);
        return response()->json(['message'=>'good contact'],200);

    }//end fun


}//end class
