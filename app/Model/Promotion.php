<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotion';
    protected $primaryKey = 'promotion_id';

    protected $fillable = [
        'promotion_id', 'employee_id','current_department','current_designation','current_pay_grade',
        'current_salary','promoted_pay_grade','new_salary','promoted_department','promoted_designation',
        'promotion_date','description','status','created_by','updated_by'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function currentDepartment(){
        return $this->belongsTo(Department::class,'current_department');
    }

    public function promotedDepartment(){
        return $this->belongsTo(Department::class,'promoted_department');
    }

    public function currentDesignation(){
        return $this->belongsTo(Designation::class,'current_designation');
    }

    public function promotedDesignation(){
        return $this->belongsTo(Designation::class,'promoted_designation');
    }

    public function currentPayGrade(){
        return $this->belongsTo(PayGrade::class,'current_pay_grade');
    }

    public function promotedPayGrade(){
        return $this->belongsTo(PayGrade::class,'promoted_pay_grade');
    }
}
