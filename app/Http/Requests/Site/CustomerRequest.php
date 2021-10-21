<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name'   => 'required',
            'email' => 'sometimes|required',
            'phone' => 'sometimes|required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يرجي ادخال الاسم',
            'email.required'=>'يرجي ادخال الايميل',
            'phone.required'=>'يرجي ادخال رقم هاتف'
        ];

    }
}
