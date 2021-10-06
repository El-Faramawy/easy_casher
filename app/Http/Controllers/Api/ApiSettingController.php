<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api\HeaderLang;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApiSettingController extends Controller
{
    use HeaderLang;
    public function app_information(Request $request){
        //check lang
        $lang=$this->lang_of_header($request->header('lang'));
        if ($lang==false){
            return response()->json(['message'=>'check the lang you sent'],405);
        }
        $settings = Setting::get();
        $settings->CollectionTranslate(['title','desc','about_app','terms_condition'],$lang);
        return response()->json($settings->first(),200);
    }//end
}//end class
