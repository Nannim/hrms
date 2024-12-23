<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrintHeadSetting extends Model
{
    protected $table = 'print_head_settings';
    protected $primaryKey = 'print_head_setting_id';

    protected $fillable = [
        'print_head_setting_id', 'description'
    ];
}
