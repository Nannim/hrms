<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PayGradeToAllowance extends Model
{
    protected $table = 'pay_grade_to_allowance';
    protected $primaryKey = 'pay_grade_to_allowance_id';

    protected $fillable = [
        'pay_grade_to_allowance_id', 'pay_grade_id','allowance_id'
    ];
}
