<?php

namespace App\Http\Controllers\Performance;

use App\Http\Requests\EmployeePerformanceRequest;

use App\Model\EmployeePerformanceDetails;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Model\PerformanceCriteria;

use App\Model\EmployeePerformance;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Model\Employee;

use Carbon\Carbon;


class EmployeePerformanceController extends Controller
{


    public function index(){
        $results = EmployeePerformance::select('employee_performance.*','employee.first_name','employee.last_name',DB::raw('AVG(rating) as avgRating'))
                    ->leftJoin('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
                    ->join('employee','employee.employee_id','=','employee_performance.employee_id')
                    ->groupBy('employee_performance_details.employee_performance_id')
                    ->orderBy('employee_performance_details.employee_performance_id','DESC')
                    ->get();

        return view('admin.performance.employeePerformance.index',['results' => $results]);
    }



    public function create(){
        $employeeList       = Employee::where('status',1)->get();
        $criteria           = PerformanceCriteria::select('performance_criteria_id','performance_criteria.performance_category_id','performance_criteria_name','performance_category.performance_category_name')
                                ->join('performance_category','performance_category.performance_category_id','=','performance_criteria.performance_category_id')
                                ->get()->toArray();

        $criteriaDataFormat = [];
        foreach ($criteria  as $value){
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
        }

        $data = [
            'employeeList'       => $employeeList,
            'criteriaDataFormat' => $criteriaDataFormat
        ];

        return view('admin.performance.employeePerformance.addEmployeePerformance',$data);
    }



    public function store(EmployeePerformanceRequest $request){
        $input = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;

        if(!isset($request->rating)){
            return redirect()->back()->withInput()->with('error', 'Enter employee rating.');
        }
        try{
            DB::beginTransaction();
                $result = EmployeePerformance::create($input);
                $criteria = $this->performanceCriteriaDataFormat($input,$result->employee_performance_id);
                 EmployeePerformanceDetails::insert($criteria);
            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('empPerformance/'.$result->employee_performance_id.'/edit')->with('success', 'Employee Performance Successfully saved.');
        }else {
            return redirect('empPerformance')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function performanceCriteriaDataFormat($data,$employee_performance_id){
        $dataFormat = [];
        for ($i=0; $i < count($data['rating']); $i++) {
            if($data['rating'][$i] !=''){
                $rating  = $data['rating'][$i];
            }else{
                $rating  = 0;
            }
            $dataFormat[$i] =[
                'employee_performance_id'       => $employee_performance_id,
                'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                'rating'                        => $rating,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ];
        }
        return $dataFormat;
    }



    public function edit($id){
        $editModeData       = EmployeePerformance::FindOrFail($id);
        $employeeList       = Employee::where('status',1)->get();
        $criteria           = PerformanceCriteria::select('performance_criteria.performance_criteria_id','performance_criteria.performance_category_id','performance_criteria_name','performance_category.performance_category_name',
                                                            'employee_performance_details.rating','employee_performance_details.employee_performance_id','employee_performance_details.employee_performance_details_id')
                                ->leftJoin('performance_category','performance_category.performance_category_id','=','performance_criteria.performance_category_id')
                                ->leftJoin('employee_performance_details','employee_performance_details.performance_criteria_id','=','performance_criteria.performance_criteria_id')
                                ->where('employee_performance_details.employee_performance_id',$id)
                                ->orWhereNull('employee_performance_details.employee_performance_id')
                                ->get()->toArray();

        $criteriaDataFormat = [];
        foreach ($criteria  as $value){
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
        }

        $data = [
            'editModeData'  => $editModeData,
            'employeeList'  => $employeeList,
            'criteriaDataFormat' => $criteriaDataFormat,
        ];

        return view('admin.performance.employeePerformance.editEmployeePerformance',$data);
    }



    public function update(EmployeePerformanceRequest $request, $id){
        $employeePerformance = EmployeePerformance::FindOrFail($id);
        $data = $request->all();
        if(isset($request->submit)){
            $data['status'] = 1;
        }
        $data['created_by'] = Auth::user()->user_id;
        $data['updated_by'] = Auth::user()->user_id;
        try{

            DB::beginTransaction();
                $employeePerformance->update($data);
                for ($i=0; $i < count($data['rating']); $i++) {
                    if($data['employee_performance_details_id'][$i] !=''){
                        $dataFormat =[
                            'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                            'rating'                        => $data['rating'][$i],
                            'created_at'                    => Carbon::now(),
                            'updated_at'                    => Carbon::now(),
                        ];
                        EmployeePerformanceDetails::where('employee_performance_details_id', $data['employee_performance_details_id'][$i])->update($dataFormat);
                    }else{
                        $dataFormat =[
                            'employee_performance_id'       => $id,
                            'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                            'rating'                        => $data['rating'][$i],
                            'created_at'                    => Carbon::now(),
                            'updated_at'                    => Carbon::now(),
                        ];
                        EmployeePerformanceDetails::create($dataFormat);
                    }
                }
            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            if(isset($request->submit)) {
                return redirect('empPerformance')->with('success', 'Employee Performance Successfully Updated.');
            }else{
                return redirect()->back()->with('success', 'Employee Performance Successfully Updated.');
            }
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function show($id){
        $criteria           = EmployeePerformance::select('employee_performance.employee_id','employee_performance.month','employee_performance.employee_performance_id',
                            'employee_performance_details.performance_criteria_id','employee_performance_details.rating','employee.first_name','employee.last_name','performance_criteria.performance_criteria_name',
                            'performance_criteria.performance_category_id','performance_category.performance_category_name','department.department_name')
                            ->join('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
                            ->join('employee','employee.employee_id','=','employee_performance.employee_id')
                            ->join('performance_criteria','performance_criteria.performance_criteria_id','=','employee_performance_details.performance_criteria_id')
                            ->join('performance_category','performance_category.performance_category_id','=','performance_criteria.performance_category_id')
                            ->join('department','department.department_id','=','employee.department_id')
                            ->where('employee_performance.employee_performance_id',$id)
                            ->get()->toArray();
        $criteriaDataFormat = [];
        foreach ($criteria  as $value){
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
        }
        return view('admin.performance.employeePerformance.employeePerformanceDetails',['criteriaDataFormat' => $criteriaDataFormat]);
    }



    public function destroy($id){
        try{

            $data = PerformanceCategory::FindOrFail($id);
            $data->delete();
            EmployeePerformanceDetails::where('employee_performance_id','=',$id)->delete();
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
