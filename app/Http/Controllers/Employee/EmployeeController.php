<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\EmployeeEducationQualification;
use App\Model\EmployeeExperience;
use App\Model\HourlySalary;
use App\Model\PayGrade;
use App\Model\PrintHeadSetting;
use App\Model\Role;
use App\Model\WorkShift;
use App\Repositories\EmployeeRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    protected $employeeRepositories;

    public function __construct(EmployeeRepository $employeeRepositories)
    {
        $this->employeeRepositories = $employeeRepositories;
    }

    public function index(Request $request)
    {
        $departmentList  = Department::get();
        $designationList = Designation::get();
        $roleList        = Role::get();

        $results = Employee::with(['userName' => function ($q) {
            $q->with('role');
        }, 'department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries'])
            ->orderBy('employee_id', 'DESC')->paginate(10);

        if (request()->ajax()) {
            if ($request->role_id != '') {
                $results = Employee::whereHas('userName', function ($q) use ($request) {
                    $q->with('role')->where('role_id', $request->role_id);
                })->with('department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries')->orderBy('employee_id', 'DESC');
            } else {
                $results = Employee::with(['userName' => function ($q) {
                    $q->with('role');
                }, 'department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries'])->orderBy('employee_id', 'DESC');
            }

            if ($request->department_id != '') {
                $results->where('department_id', $request->department_id);
            }

            if ($request->designation_id != '') {
                $results->where('designation_id', $request->designation_id);
            }

            if ($request->employee_name != '') {
                $results->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->employee_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->employee_name . '%');
                });
            }

            $results = $results->paginate(10);
            return View('admin.employee.employee.pagination', ['results' => $results])->render();
        }

        return view('admin.employee.employee.index', ['results' => $results, 'departmentList' => $departmentList, 'designationList' => $designationList, 'roleList' => $roleList]);
    }

    // printing employee list

    public function printEmployee(Request $request)
    {
        if ($request->role_id != '') {
            $results = Employee::whereHas('userName', function ($q) use ($request) {
                $q->with('role')->where('role_id', $request->role_id);
            })->with('department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries')->orderBy('employee_id', 'DESC');
        } else {
            $results = Employee::with(['userName' => function ($q) {
                $q->with('role');
            }, 'department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries'])->orderBy('employee_id', 'DESC');
        }

        if ($request->department_id != '') {
            $results->where('department_id', $request->department_id);
        }

        if ($request->designation_id != '') {
            $results->where('designation_id', $request->designation_id);
        }

        if ($request->employee_name != '') {
            $results->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->employee_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->employee_name . '%');
            });
        }

        $results = $results->get();

        $printHead = PrintHeadSetting::first();

        return view('admin.employee.employee.print_employee', ['results' => $results, 'printHead' => $printHead]);
    }

    public function create()
    {
        $userList           = User::where('status', 1)->get();
        $roleList           = Role::get();
        $departmentList     = Department::get();
        $designationList    = Designation::get();
        $branchList         = Branch::get();
        $workShiftList      = WorkShift::get();
        $supervisorList     = Employee::where('status', 1)->get();
        $payGradeList       = PayGrade::all();
        $hourlyPayGradeList = HourlySalary::all();

        $data = [
            'userList'           => $userList,
            'roleList'           => $roleList,
            'departmentList'     => $departmentList,
            'designationList'    => $designationList,
            'branchList'         => $branchList,
            'supervisorList'     => $supervisorList,
            'workShiftList'      => $workShiftList,
            'payGradeList'       => $payGradeList,
            'hourlyPayGradeList' => $hourlyPayGradeList,
        ];

        return view('admin.employee.employee.addEmployee', $data);
    }

    public function store(EmployeeRequest $request)
    {
        $photo = $request->file('photo');
        if ($photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            $employeePhoto['photo'] = $imgName;
        }
        $employeeDataFormat = $this->employeeRepositories->makeEmployeePersonalInformationDataFormat($request->all());
        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat = $this->employeeRepositories->makeEmployeeAccountDataFormat($request->all());
            $parentData                = User::create($employeeAccountDataFormat);

            $employeeData['user_id'] = $parentData->user_id;
            $childData               = Employee::create($employeeData);

            $employeeEducationData = $this->employeeRepositories->makeEmployeeEducationDataFormat($request->all(), $childData->employee_id);
            if (count($employeeEducationData) > 0) {
                EmployeeEducationQualification::insert($employeeEducationData);
            }

            $employeeExperienceData = $this->employeeRepositories->makeEmployeeExperienceDataFormat($request->all(), $childData->employee_id);
            if (count($employeeExperienceData) > 0) {
                EmployeeExperience::insert($employeeExperienceData);
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('employee')->with('success', 'Employee information successfully saved.');
        } else {
            return redirect('employee')->with('error', 'Something Error Found !, Please try again.');
        }
    }

    public function edit($id)
    {
        $userList           = User::where('status', 1)->get();
        $roleList           = Role::get();
        $departmentList     = Department::get();
        $designationList    = Designation::get();
        $branchList         = Branch::get();
        $supervisorList     = Employee::where('status', 1)->get();
        $editModeData       = Employee::findOrFail($id);
        $workShiftList      = WorkShift::get();
        $payGradeList       = PayGrade::all();
        $hourlyPayGradeList = HourlySalary::all();

        $employeeAccountEditModeData        = User::where('user_id', $editModeData->user_id)->first();
        $educationQualificationEditModeData = EmployeeEducationQualification::where('employee_id', $id)->get();
        $experienceEditModeData             = EmployeeExperience::where('employee_id', $id)->get();

        $data = [
            'userList'                           => $userList,
            'roleList'                           => $roleList,
            'departmentList'                     => $departmentList,
            'designationList'                    => $designationList,
            'branchList'                         => $branchList,
            'supervisorList'                     => $supervisorList,
            'workShiftList'                      => $workShiftList,
            'payGradeList'                       => $payGradeList,
            'editModeData'                       => $editModeData,
            'hourlyPayGradeList'                 => $hourlyPayGradeList,
            'employeeAccountEditModeData'        => $employeeAccountEditModeData,
            'educationQualificationEditModeData' => $educationQualificationEditModeData,
            'experienceEditModeData'             => $experienceEditModeData,
        ];

        return view('admin.employee.employee.editEmployee', $data);

    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $photo    = $request->file('photo');
        if ($photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            if (file_exists('uploads/employeePhoto/' . $employee->photo) and !empty($employee->photo)) {
                unlink('uploads/employeePhoto/' . $employee->photo);
            }
            $employeePhoto['photo'] = $imgName;
        }
        $employeeDataFormat = $this->employeeRepositories->makeEmployeePersonalInformationDataFormat($request->all());
        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat = $this->employeeRepositories->makeEmployeeAccountDataFormat($request->all(), 'update');
            User::where('user_id', $employee->user_id)->update($employeeAccountDataFormat);

            // Update Personal Information
            $employee->update($employeeData);

            // Delete education qualification
            EmployeeEducationQualification::whereIn('employee_education_qualification_id', explode(',', $request->delete_education_qualifications_cid))->delete();

            // Update Education Qualification
            $employeeEducationData = $this->employeeRepositories->makeEmployeeEducationDataFormat($request->all(), $id, 'update');
            foreach ($employeeEducationData as $educationValue) {
                $cid = $educationValue['educationQualification_cid'];
                unset($educationValue['educationQualification_cid']);
                if ($cid != "") {
                    EmployeeEducationQualification::where('employee_education_qualification_id', $cid)->update($educationValue);
                } else {
                    $educationValue['employee_id'] = $id;
                    EmployeeEducationQualification::create($educationValue);
                }
            }

            // Delete experience
            EmployeeExperience::whereIn('employee_experience_id', explode(',', $request->delete_experiences_cid))->delete();

            // Update Education Qualification
            $employeeExperienceData = $this->employeeRepositories->makeEmployeeExperienceDataFormat($request->all(), $id, 'update');
            if (count($employeeExperienceData) > 0) {
                foreach ($employeeExperienceData as $experienceValue) {
                    $cid = $experienceValue['employeeExperience_cid'];
                    unset($experienceValue['employeeExperience_cid']);
                    if ($cid != "") {
                        EmployeeExperience::where('employee_experience_id', $cid)->update($experienceValue);
                    } else {
                        $experienceValue['employee_id'] = $id;
                        EmployeeExperience::create($experienceValue);
                    }
                }
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Employee information successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }

    public function show($id)
    {

        $employeeInfo       = Employee::where('employee.employee_id', $id)->first();
        $employeeExperience = EmployeeExperience::where('employee_id', $id)->get();
        $employeeEducation  = EmployeeEducationQualification::where('employee_id', $id)->get();

        return view('admin.user.user.profile', ['employeeInfo' => $employeeInfo, 'employeeExperience' => $employeeExperience, 'employeeEducation' => $employeeEducation]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Employee::FindOrFail($id);
            if (!is_null($data->photo)) {
                if (file_exists('uploads/employeePhoto/' . $data->photo) and !empty($data->photo)) {
                    unlink('uploads/employeePhoto/' . $data->photo);
                }
            }
            $result = $data->delete();
            if ($result) {
                DB::table('user')->where('user_id', $data->user_id)->delete();
                DB::table('employee_education_qualification')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_experience')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_attendance')->where('finger_print_id', $data->finger_id)->delete();
                DB::table('employee_award')->where('employee_id', $data->employee_id)->delete();

                DB::table('employee_bonus')->where('employee_id', $data->employee_id)->delete();

                DB::table('promotion')->where('employee_id', $data->employee_id)->delete();

                DB::table('salary_details')->where('employee_id', $data->employee_id)->delete();

                DB::table('training_info')->where('employee_id', $data->employee_id)->delete();

                DB::table('warning')->where('warning_to', $data->employee_id)->delete();

                DB::table('leave_application')->where('employee_id', $data->employee_id)->delete();

                DB::table('employee_performance')->where('employee_id', $data->employee_id)->delete();

                DB::table('termination')->where('terminate_to', $data->employee_id)->delete();

                DB::table('notice')->where('created_by', $data->employee_id)->delete();

            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }

    public function getBulkUpload()
    {

        // return "bulk";
        return view('admin.employee.employee.bulk_upload');
    }

    public function storeBulk(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'upload_file' => 'required|mimes:csv,txt',
        ], [
            'upload_file.mimes' => 'oops ! only CSV file acceptable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $file = $request->file('upload_file');
        // return file_get_contents($file);
        $column_name = array();

        $final_data = array();

        $file_data = file_get_contents($file);

        $data_array = array_map("str_getcsv", explode("\n", $file_data));

        $labels = array_shift($data_array);

        foreach ($labels as $label) {
            $column_name[] = $label;
        }

        $count = count($data_array);

        for ($j = 0; $j < $count; $j++) {
            $data = array_combine($column_name, $data_array[$j]);

            $final_data[$j] = $data;
        }

        // return $final_data;
        try
        {
            DB::beginTransaction();
            foreach ($final_data as $value) {

                // insert this into databse

                $employeeData              = $this->employeeRepositories->makeEmployeePersonalInformationDataFormat($value);
                $employeeAccountDataFormat = $this->employeeRepositories->makeEmployeeAccountDataFormat($value);
                $parentData                = User::create($employeeAccountDataFormat);

                $employeeData['user_id'] = $parentData->user_id;
                Employee::create($employeeData);

            }
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employee Uploaded');

        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }

    }

}
