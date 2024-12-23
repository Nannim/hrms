<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HourlyPayGradeRequest extends FormRequest
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
        if(isset($this->hourlyWages)){
            return [
                'hourly_grade'  => 'required|unique:hourly_salaries,hourly_grade,'.$this->hourlyWages.',hourly_salaries_id',
                'hourly_rate'=>'required|numeric'
            ];
        }
        return [
            'hourly_grade'=>'required|unique:hourly_salaries',
            'hourly_rate'=>'required|numeric'
        ];
    }
}
