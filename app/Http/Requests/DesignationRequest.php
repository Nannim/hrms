<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
        if(isset($this->designation)){
            return [
                'designation_name'  => 'required|unique:designation,designation_name,'.$this->designation.',designation_id'
            ];
        }
        return [
            'designation_name'=>'required|unique:designation',
        ];
    }
}
