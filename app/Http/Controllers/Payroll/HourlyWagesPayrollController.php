<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Requests\HourlyPayGradeRequest;

use App\Http\Controllers\Controller;

use App\Model\HourlySalary;

use App\Model\Employee;

use Illuminate\Http\Request;


class HourlyWagesPayrollController extends Controller
{


    public function index(){
        $results = HourlySalary::get();
        return view('admin.payroll.hourlyWagesSalary.index',['results' => $results]);
    }



    public function create(){
        return view('admin.payroll.hourlyWagesSalary.form');
    }



    public function store(HourlyPayGradeRequest $request) {
        $input = $request->all();
        try{
            HourlySalary::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('hourlyWages')->with('success', 'Hourly wages Pay grade successfully saved.');
        }else {
            return redirect('hourlyWages')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id){
        $editModeData = HourlySalary::FindOrFail($id);
        return view('admin.payroll.hourlyWagesSalary.form',compact('editModeData'));
    }



    public function update(HourlyPayGradeRequest $request,$id) {
        $data = HourlySalary::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Hourly wages Pay grade successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id){


         $count = Employee::where('hourly_salaries_id','=',$id)->count();

         if($count>0){
            
            return "hasForeignKey";
         }

        try{
            $data = HourlySalary::FindOrFail($id);
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
