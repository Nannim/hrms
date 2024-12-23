<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllowanceRequest extends FormRequest
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
        if(isset($this->allowance)){
            return [
                'allowance_name'  => 'required|unique:allowance,allowance_name,'.$this->allowance.',allowance_id',
                'limit_per_month'=>'required|numeric'
            ];
        }
        return [
            'allowance_name'=>'required|unique:allowance',
            'limit_per_month'=>'required|numeric'
        ];
    }
}
