<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use App\Http\Requests\AwardRequest;

use App\Model\EmployeeAward;

use Illuminate\Http\Request;


class AwardController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository){
        $this->commonRepository = $commonRepository;
    }

	
	
    public function index(){
        $results = EmployeeAward::with('employee')->orderBy('employee_award_id','DESC')->get();
        return view('admin.award.index',['results' => $results]);
    }



    public function create(){
        $employeeList = $this->commonRepository->employeeList();
        return view('admin.award.form',['employeeList' => $employeeList]);
    }



    public function store(AwardRequest $request) {
        $input = $request->all();
        try{
            EmployeeAward::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('award')->with('success', 'Award Successfully saved.');
        }else {
            return redirect('award')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id){
        $employeeList = $this->commonRepository->employeeList();
        $editModeData = EmployeeAward::FindOrFail($id);
        return view('admin.award.form',compact('editModeData','employeeList'));
    }



    public function update(AwardRequest $request,$id) {
        $data = EmployeeAward::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Award Successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id){
        try{
            $data = EmployeeAward::FindOrFail($id);
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
