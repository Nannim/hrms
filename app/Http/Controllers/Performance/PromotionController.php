<?php

namespace App\Http\Controllers\Performance;

use App\Http\Requests\PromotionRequest;

use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Model\Promotion;

use App\Model\Employee;

use App\Model\PayGrade;


class PromotionController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }



    public function index()
    {
        $results = Promotion::with(['employee','currentDepartment','promotedDepartment','currentDesignation','promotedDesignation','currentPayGrade','promotedPayGrade'])->get();
        return view('admin.performance.promotion.index',['results' => $results]);
    }



    public function create()
    {
        $employeeList       = $this->commonRepository->employeeList();
        $payGradeList       = $this->commonRepository->payGradeList();
        $designationList    = $this->commonRepository->designationList();
        $departmentList     = $this->commonRepository->departmentList();
        $data =[
            'employeeList'      => $employeeList,
            'payGradeList'      => $payGradeList,
            'departmentList'    => $departmentList,
            'designationList'   => $designationList,
        ];
        return view('admin.performance.promotion.form',$data);
    }



    public function findEmployeeInfo(Request $request)
    {
       return  Employee::with('department','designation','payGrade')->where('employee_id',$request->employee_id)->first();
    }



    public function findPayGradeWiseSalary(Request $request){
       return  PayGrade::where('pay_grade_id',$request->pay_grade_id)->first();
    }



    public function store(PromotionRequest $request)
    {
        $input                   = $request->all();
        $input['promotion_date'] = dateConvertFormtoDB($request->promotion_date);
        $input['created_by']     = Auth::user()->user_id;
        $input['updated_by']     = Auth::user()->user_id;
        try{
            $result = Promotion::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('promotion/'.$result->promotion_id.'/edit')->with('success', 'Employee promotion successfully saved.');
        }else {
            return redirect('promotion')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id)
    {
        $editModeData       = Promotion::FindOrFail($id);
        $employeeList       = $this->commonRepository->employeeList();
        $payGradeList       = $this->commonRepository->payGradeList();
        $designationList    = $this->commonRepository->designationList();
        $departmentList     = $this->commonRepository->departmentList();
        $data =[
            'employeeList'      => $employeeList,
            'payGradeList'      => $payGradeList,
            'departmentList'    => $departmentList,
            'designationList'   => $designationList,
            'editModeData'      => $editModeData,
        ];
        return view('admin.performance.promotion.form',$data);
    }



    public function update(PromotionRequest $request, $id)
    {
        $data                    = Promotion::FindOrFail($id);
        $input                   = $request->all();
        $input['promotion_date'] = dateConvertFormtoDB($request->promotion_date);
        $input['created_by']     = Auth::user()->user_id;
        $input['updated_by']     = Auth::user()->user_id;
        try{
            DB::beginTransaction();
                if($request->update == "Update"){
                    $data->update($input);
                }else{
                    $input['status'] = 2;
                    $data->update($input);
                    DB::table('employee')->where('employee_id', $request->employee_id)->update([
                        'department_id'  => $request->promoted_department,
                        'designation_id' =>$request->promoted_designation,
                        'pay_grade_id'   =>$request->promoted_pay_grade,
                    ]);
                }
            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Employee promotion successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id){
        try{
            $data = Promotion::FindOrFail($id);
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            echo "success";
        }elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }


}
