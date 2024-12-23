<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrainingInfo extends Model
{
    protected $table = 'training_info';
    protected $primaryKey = 'training_info_id';

    protected $fillable = [
        'training_info_id', 'training_type_id','employee_id','subject','start_date','end_date','description','certificate','created_by','updated_by'
    ];


    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }


    public function trainingType(){
        return $this->belongsTo(TrainingType::class,'training_type_id');
    }


    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
}
