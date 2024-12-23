<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicHolidayRequest extends FormRequest
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
        return [
            'holiday_id'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'holiday_id.required' => 'The holiday name field is required.',
        ];
    }
}
