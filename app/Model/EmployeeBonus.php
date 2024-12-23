<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeBonus extends Model
{
    protected $table = 'employee_bonus';
    protected $primaryKey = 'employee_bonus_id';

    protected $fillable = [
        'employee_bonus_id','bonus_setting_id','employee_id','month','gross_salary','basic_salary','bonus_amount','tax'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function festivalName(){
        return $this->belongsTo(BonusSetting::class,'bonus_setting_id');
    }

    public function payGrade(){
        return $this->belongsTo(PayGrade::class,'pay_grade_id');
    }

    public function hourlySalaries(){
        return $this->belongsTo(HourlySalary::class,'hourly_salaries_id');
    }

}
