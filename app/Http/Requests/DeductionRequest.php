<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductionRequest extends FormRequest
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
        if(isset($this->deduction)){
            return [
                'deduction_name'  => 'required|unique:deduction,deduction_name,'.$this->deduction.',deduction_id',
                'limit_per_month'=>'required|numeric'
            ];
        }
        return [
            'deduction_name'=>'required|unique:deduction',
            'limit_per_month'=>'required|numeric'
        ];
    }
}
