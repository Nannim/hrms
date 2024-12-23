<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\DepartmentRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Department;

use App\Model\Employee;


class DepartmentController extends Controller
{

    public function index(){
        $results = Department::get();
        return view('admin.employee.department.index',['results'=>$results]);
    }


    public function create(){
        return view('admin.employee.department.form');
    }


    public function store(DepartmentRequest $request) {
        $input = $request->all();
        try{
            Department::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('department')->with('success', 'Department successfully saved.');
        }else {
            return redirect('department')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $editModeData = Department::findOrFail($id);
        return view('admin.employee.department.form',['editModeData' => $editModeData]);
    }


    public function update(DepartmentRequest $request,$id) {
        $department = Department::findOrFail($id);
        $input = $request->all();
        try{
            $department->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Department successfully updated ');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){

      $count = Employee::where('department_id','=',$id)->count();

         if($count>0){

            return  'hasForeignKey';
         }


        try{
            $department = Department::FindOrFail($id);
            $department->delete();
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
