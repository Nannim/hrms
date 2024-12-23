<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeRequest extends FormRequest
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
        if(isset($this->leaveType)){
            return [
                'leave_type_name'  => 'required|unique:leave_type,leave_type_name,'.$this->leaveType.',leave_type_id',
                'num_of_day'=>'required|numeric'
            ];
        }
        return [
            'leave_type_name'=>'required|unique:leave_type',
            'num_of_day'=>'required|numeric',
        ];
    }
}
