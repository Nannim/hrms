<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PayGradeToDeduction extends Model
{
    protected $table = 'pay_grade_to_deduction';
    protected $primaryKey = 'pay_grade_to_deduction_id';

    protected $fillable = [
        'pay_grade_to_deduction_id', 'pay_grade_id','deduction_id'
    ];
}
