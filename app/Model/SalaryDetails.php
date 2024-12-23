<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    protected $table = 'salary_details';
    protected $primaryKey = 'salary_details_id';

    protected $fillable = [
        'salary_details_id', 'employee_id','month_of_salary','basic_salary','total_allowance','total_deduction','total_late','total_late_amount','total_absence',
        'total_absence_amount','overtime_rate','total_over_time_hour','total_overtime_amount','total_present','total_leave','total_working_days','tax','gross_salary',
        'comment','status','created_by','updated_by','payment_method','action','hourly_rate','taxable_salary','per_day_salary','net_salary','working_hour'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function payGrade(){
        return $this->belongsTo(PayGrade::class,'pay_grade_id');
    }

    public function hourlySalaries(){
        return $this->belongsTo(HourlySalary::class,'hourly_salaries_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function designation(){
        return $this->belongsTo(Designation::class,'designation_id');
    }
}
