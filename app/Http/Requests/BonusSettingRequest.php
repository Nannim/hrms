<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonusSettingRequest extends FormRequest
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
        if(isset($this->bonusSetting)){
            return [
                'festival_name'  => 'required|unique:bonus_setting,festival_name,'.$this->bonusSetting.',bonus_setting_id',
                'percentage_of_bonus'=>'required',
                'bonus_type'=>'required',
            ];
        }
        return [
            'festival_name'=>'required|unique:bonus_setting',
            'percentage_of_bonus'=>'required',
            'bonus_type'=>'required',
        ];
    }
}
