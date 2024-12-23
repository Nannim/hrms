<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminationRequest extends FormRequest
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
            'terminate_to'=>'required',
            'terminate_by'=>'required',
            'termination_type'=>'required',
            'subject'=>'required',
            'notice_date'=>'required',
            'termination_date'=>'required',
        ];
    }
}
