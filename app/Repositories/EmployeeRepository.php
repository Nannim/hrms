<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;


class EmployeeRepository
{

    public function makeEmployeeAccountDataFormat($data,$action = false){
        $employeeAccountData['role_id']     = $data['role_id'];
        if($action != 'update'){
            $employeeAccountData['password']    = Hash::make($data['password']);
        }
        $employeeAccountData['user_name']   = $data['user_name'];
        $employeeAccountData['status']      = $data['status'];
        $employeeAccountData['created_by']  = Auth::user()->user_id;
        $employeeAccountData['updated_by']  = Auth::user()->user_id;

        return $employeeAccountData;
    }


    public function makeEmployeePersonalInformationDataFormat($data){
        $employeeData['first_name']     = $data['first_name'];
        $employeeData['last_name']      = $data['last_name'];
        $employeeData['finger_id']      = $data['finger_id'];
        $employeeData['department_id']  = $data['department_id'];
        $employeeData['designation_id'] = $data['designation_id'];
        $employeeData['branch_id']      = $data['branch_id'];
        $employeeData['supervisor_id']  = $data['supervisor_id'];
        $employeeData['work_shift_id']  = $data['work_shift_id'];
        $employeeData['pay_grade_id']   = $data['pay_grade_id'];
        $employeeData['hourly_salaries_id']   = $data['hourly_salaries_id'];
        $employeeData['email']          = $data['email'];
        $employeeData['date_of_birth']  = dateConvertFormtoDB($data['date_of_birth']);
        $employeeData['date_of_joining']= dateConvertFormtoDB($data['date_of_joining']);
        $employeeData['date_of_leaving']= dateConvertFormtoDB($data['date_of_leaving']);
        $employeeData['marital_status'] = $data['marital_status'];
        $employeeData['address']        = $data['address'];
        $employeeData['emergency_contacts'] = $data['emergency_contacts'];
        $employeeData['gender']         = $data['gender'];
        $employeeData['religion']       = $data['religion'];
        $employeeData['phone']          = $data['phone'];
        $employeeData['status']         = $data['status'];
        $employeeData['created_by']     = Auth::user()->user_id;
        $employeeData['updated_by']     = Auth::user()->user_id;

        return $employeeData;
    }


    public function makeEmployeeEducationDataFormat($data,$employee_id,$action = false){
        $educationData = [];
        if(isset($data['institute'])) {
            for ($i=0; $i < count($data['institute']); $i++) {
                $educationData[$i] =[
                    'employee_id'       => $employee_id,
                    'institute'         => $data['institute'][$i],
                    'board_university'  => $data['board_university'][$i],
                    'degree'            => $data['degree'][$i],
                    'passing_year'      => $data['passing_year'][$i],
                    'result'            => $data['result'][$i],
                    'cgpa'              => $data['cgpa'][$i],
                ];
                if($action == 'update'){
                    $educationData[$i]['educationQualification_cid'] = $data['educationQualification_cid'][$i];
                }
            }
        }
        return $educationData;
    }


    public function makeEmployeeExperienceDataFormat($data,$employee_id,$action = false){
        $experienceData = [];
        if(isset($data['organization_name'])) {
            for ($i = 0; $i < count($data['organization_name']); $i++) {
                $experienceData[$i] = [
                    'employee_id'           => $employee_id,
                    'organization_name'     => $data['organization_name'][$i],
                    'designation'           => $data['designation'][$i],
                    'from_date'             => dateConvertFormtoDB($data['from_date'][$i]),
                    'to_date'               => dateConvertFormtoDB($data['to_date'][$i]),
                    'responsibility'        => $data['responsibility'][$i],
                    'skill'                 => $data['skill'][$i],
                ];
                if($action == 'update'){
                    $experienceData[$i]['employeeExperience_cid'] = $data['employeeExperience_cid'][$i];
                }
            }
        }
        return $experienceData;
    }

}
