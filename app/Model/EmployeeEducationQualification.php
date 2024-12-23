<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationQualification extends Model
{
    protected $table = 'employee_education_qualification';
    protected $primaryKey = 'employee_education_qualification_id';
    protected $fillable = [
        'employee_education_qualification_id','employee_id','institute','board_university','degree','passing_year','result','cgpa','year'
    ];
}
