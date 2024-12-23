<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerformanceCriteriaRequest extends FormRequest
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

        if(isset($this->performanceCriteriaId)){
            return [
                'performance_category_id'=>'required',
                'performance_criteria_name'  => 'required|unique:performance_criteria,performance_criteria_name,'.$this->performanceCriteriaId.',performance_criteria_id'
            ];
        }
        return [
            'performance_category_id'=>'required',
            'performance_criteria_name'=>'required|unique:performance_criteria',
        ];
    }

    public function messages()
    {
        return [
            'performance_category_id.required' => 'The performance category field is required.',
        ];
    }
}
