<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeeklyHolidayRequest extends FormRequest
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
        if(isset($this->weeklyHoliday)){
            return [
                'day_name'  => 'required|unique:weekly_holiday,day_name,'.$this->weeklyHoliday.',week_holiday_id'
            ];
        }
        return [
            'day_name'=>'required|unique:weekly_holiday',
        ];
    }

    public function messages()
    {
        return [
            'day_name.required' => 'The weekly holiday name field is required.',
            'day_name.unique' => 'The weekly holiday name has already been taken.',
        ];
    }
}
