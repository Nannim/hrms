<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            'employee_id'           =>'required',
            'current_department'    =>'required',
            'current_designation'   =>'required',
            'current_pay_grade'     =>'required',
            'current_salary'        =>'required',
            'promoted_pay_grade'    =>'required',
            'new_salary'            =>'required',
            'promoted_department'   =>'required',
            'promoted_designation'  =>'required',
            'promotion_date'        =>'required',
        ];
    }
}
