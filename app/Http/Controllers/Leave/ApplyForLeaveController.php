<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\ApplyForLeaveRequest;

use App\Repositories\CommonRepository;

use App\Repositories\LeaveRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Model\LeaveApplication;

use Illuminate\Http\Request;

use App\Model\LeaveType;



class ApplyForLeaveController extends Controller
{

    protected $commonRepository;
    protected $leaveRepository;

    public function __construct(CommonRepository $commonRepository,LeaveRepository $leaveRepository){
        $this->commonRepository = $commonRepository;
        $this->leaveRepository  = $leaveRepository;
    }


    public function index(){
        $results = LeaveApplication::with(['employee','leaveType','approveBy','rejectBy'])
                    ->where('employee_id', session('logged_session_data.employee_id'))
                    ->orderBy('leave_application_id', 'desc')
                    ->paginate(10);
        return view('admin.leave.applyForLeave.index',['results'=>$results]);
    }


    public function create(){
        $leaveTypeList      = $this->commonRepository->leaveTypeList();
        $getEmployeeInfo    = $this->commonRepository->getEmployeeInfo(Auth::user()->user_id);
        return view('admin.leave.applyForLeave.leave_application_form',['leaveTypeList' => $leaveTypeList,'getEmployeeInfo' => $getEmployeeInfo]);
    }


    public function getEmployeeLeaveBalance(Request $request){
         $leave_type_id = $request->leave_type_id;
         $employee_id   = $request->employee_id;
         if($leave_type_id != '' && $employee_id != ''){
             return $this->leaveRepository->calculateEmployeeLeaveBalance($leave_type_id,$employee_id);
         }
    }


    public function applyForTotalNumberOfDays(Request $request){
         $application_from_date = dateConvertFormtoDB($request->application_from_date);
         $application_to_date   = dateConvertFormtoDB($request->application_to_date);
         return $this->leaveRepository->calculateTotalNumberOfLeaveDays($application_from_date,$application_to_date);
    }


    public function store(ApplyForLeaveRequest $request){
        $input = $request->all();
        $input['application_from_date'] = dateConvertFormtoDB($request->application_from_date);
        $input['application_to_date']   = dateConvertFormtoDB($request->application_to_date);
        $input['application_date']      =  date('Y-m-d');
        try{
            LeaveApplication::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('applyForLeave')->with('success', 'Leave application successfully send.');
        } else {
            return redirect('applyForLeave')->with('error', 'Something error found !, Please try again.');
        }
    }


}
