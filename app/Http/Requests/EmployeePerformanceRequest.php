<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeePerformanceRequest extends FormRequest
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
        if(isset($this->employeePerformanceId)){
            return [
                'employee_id'=>'required',
                'month' => 'required|unique:employee_performance,month,'.$this->employeePerformanceId.',employee_performance_id,employee_id,'.$_POST['employee_id'],
            ];
        }
        return [
            'employee_id'=>'required',
            'month' => 'required|unique:employee_performance,month,NULL,employee_performance_id,employee_id,'.$_POST['employee_id'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'The employee name field is required.',
        ];
    }

}
