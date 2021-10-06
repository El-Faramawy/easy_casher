<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'en_title' => 'required|string',
            'ar_title' =>'required|string|max:191',
            'address1' => 'required|string|max:191',
            'address2' =>'required|string|max:191',
            'phone1' => 'required|string|max:191',
            'phone2' =>'required|string|max:191',
            'android_app' => 'required|string|max:191',
            'ios_app' =>'required|string|max:191',
            'email1' => 'required|string|max:191',
            'email2' =>'required|string|max:191',
            'login_banner'=>'nullable|image|mimes:jpeg,jpg,png,gif',
        ];
    }
}
