<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayGradeRequest extends FormRequest
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
        if(isset($this->payGrade)){
            return [
                'pay_grade_name'    => 'required|unique:pay_grade,pay_grade_name,'.$this->payGrade.',pay_grade_id',
                   'gross_salary'   =>'required|numeric',
            'basic_salary'          =>'required|numeric',
            ];
        }
        return [
            'pay_grade_name'        =>'required|unique:pay_grade',
            'gross_salary'          =>'required|numeric',
            'basic_salary'          =>'required|numeric',
        ];
    }
}
