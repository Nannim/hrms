<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AwardRequest extends FormRequest
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
            'employee_id'=>'required',
            'award_name'=>'required',
            'gift_item'=>'required',
            'month'=>'required',
        ];


    }

    public function messages()
    {
        return [
            'employee_id.required' => 'The employee name field is required.',
        ];
    }
}
