<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingTypeRequest extends FormRequest
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
        if(isset($this->trainingType)){
            return [
                'training_type_name'  => 'required|unique:training_type,training_type_name,'.$this->trainingType.',training_type_id'
            ];
        }
        return [
            'training_type_name'=>'required|unique:training_type',
        ];
    }
}
