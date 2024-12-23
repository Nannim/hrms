<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeAward extends Model
{
    protected $table = 'employee_award';
    protected $primaryKey = 'employee_award_id';

    protected $fillable = [
        'employee_award_id', 'employee_id','award_name','gift_item','month'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
}
