<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeTrainingRequest extends FormRequest
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
        if(isset($this->trainingInfo)){
            return [
                'employee_id'       =>'required',
                'training_type_id'  => 'required',
                'subject'           => 'required',
                'start_date'        => 'required',
                'end_date'          => 'required',
                'certificate'        => 'nullable|mimes:jpeg,jpg,png,pdf|max:1024',
                'description'        => 'required',
            ];
        }
        return [
            'training_type_id'  => 'required',
            'employee_id'       => 'required|unique:training_info,employee_id,NULL,training_info_id,training_type_id,'.$_POST['training_type_id'],
            'subject'           => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'certificate'       => 'mimes:jpeg,jpg,png,pdf|max:1024',
            'description'        => 'required',
        ];

    }

    public function messages()
    {
        return [
            'employee_id.required' => 'The employee name field is required.',
            'training_type_id.required' => 'The training type field is required.',
        ];
    }
}
