<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    protected $table = 'job_applicant';
    protected $primaryKey = 'job_applicant_id';

    protected $fillable = [
        'job_applicant_id', 'job_id','post','applicant_name','applicant_email','phone','attached_resume','status','cover_letter','application_date'
    ];

    public function job(){
        return $this->belongsTo(Job::class,'job_id');
    }

    public function interviewInfo(){
        return $this->hasOne(Interview::class,'job_applicant_id');
    }
}
