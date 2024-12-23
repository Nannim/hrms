<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalaryDeductionForLateAttendance extends Model
{
    protected $table = 'salary_deduction_for_late_attendance';
    protected $primaryKey = 'salary_deduction_for_late_attendance_id';

    protected $fillable = [
        'salary_deduction_for_late_attendance_id', 'for_days','day_of_salary_deduction','status'
    ];
}
