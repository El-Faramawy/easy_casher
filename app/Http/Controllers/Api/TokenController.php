<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TokenRequest;
use App\Models\FirebaseToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function token_update(Request $request)
    {
        //create or update
        $token=new TokenRequest();
        $this->validate($request,
            array_merge_recursive($token->rules(),
            ['software_type'=>'required|in:ios,android']));
        return response()->json(FirebaseToken::updateOrCreate(
            [
                'user_id'=>  $request->user_id,
                'phone_token'=>  $request->firebase_token,
                'software_type'=>  $request->software_type,
            ]
        ),200);
    }

    /**
     * @param TokenRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function token_delete(TokenRequest $request)
    {
        $firebase= FirebaseToken::where([
            'user_id'=>$request->user_id,
            'phone_token'=> $request->firebase_token
        ])->delete();
        //delete the token
        if ($firebase) {
            return  response()->json(['message'=>'the token is deleted'],200);
        }else{
            return  response()->json(['message'=>'the firebase Token not exist'],404);
        }
    }//end  fun

}//end class
