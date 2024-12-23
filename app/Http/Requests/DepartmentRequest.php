<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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

        if(isset($this->department)){
            return [
                'department_name'  => 'required|unique:department,department_name,'.$this->department.',department_id'
            ];
        }
        return [
            'department_name'=>'required|unique:department',
        ];

    }
}
