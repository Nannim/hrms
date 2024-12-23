<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerformanceCategoryRequest extends FormRequest
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
        if(isset($this->performanceCategoryId)){
            return [
                'performance_category_name'  => 'required|unique:performance_category,performance_category_name,'.$this->performanceCategoryId.',performance_category_id'
            ];
        }
        return [
            'performance_category_name'=>'required|unique:performance_category',
        ];
    }
}
