<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $table      = 'employee';
    protected $primaryKey = 'employee_id';
    protected $fillable   = [
        'employee_id', 'user_id', 'finger_id', 'department_id', 'designation_id', 'branch_id', 'supervisor_id', 'work_shift_id', 'email', 'first_name',
        'last_name', 'date_of_birth', 'date_of_joining', 'date_of_leaving', 'gender', 'marital_status',
        'photo', 'address', 'emergency_contacts', 'phone', 'status', 'created_by', 'updated_by', 'religion', 'pay_grade_id', 'hourly_salaries_id',
    ];

    public function userName()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault([
            'department_id'   => 0,
            'department_name' => 'N/A',
        ]);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->withDefault([
            'designation_id'   => 0,
            'designation_name' => 'N/A',
        ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault([
            'branch_id'   => 0,
            'branch_name' => 'N/A',
        ]);
    }

    public function payGrade()
    {
        return $this->belongsTo(PayGrade::class, 'pay_grade_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->withDefault([
            'role_id'   => 0,
            'role_name' => 'N/A',
        ]);
    }

    public function hourlySalaries()
    {
        return $this->belongsTo(HourlySalary::class, 'hourly_salaries_id');
    }

}
