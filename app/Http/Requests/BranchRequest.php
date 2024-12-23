<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        if(isset($this->branch)){
            return [
                'branch_name'  => 'required|unique:branch,branch_name,'.$this->branch.',branch_id'
            ];
        }
        return [
            'branch_name'=>'required|unique:branch',
        ];
    }
}
