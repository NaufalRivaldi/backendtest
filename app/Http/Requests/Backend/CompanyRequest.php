<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $image = '|required';
        if(empty($request->id)){
            $image = '';
        }
        return [
            'name' => 'required|max:100|',
            'email' => 'required|email|max:100',
            'postcode' => 'required|numeric',
            'prefecture_id' => 'required',
            'city' => 'required',
            'local' => 'required',
            'business_hour' => 'max:45',
            'regular_holiday' => 'numeric',
            'phone' => 'max:15',
            'fax' => 'max:15',
            'url' => 'url',
            'license_number' => 'max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'.$image
        ];
    }
}
