<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\DesignationRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Designation;

use App\Model\Employee;



class DesignationController extends Controller
{

    public function index(){
        $results = Designation::get();
        return view('admin.employee.designation.index',['results'=>$results]);
    }


    public function create(){
        return view('admin.employee.designation.form');
    }


    public function store(DesignationRequest $request) {
        $input = $request->all();
        try{
            Designation::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('designation')->with('success', 'Designation Successfully saved.');
        }else {
            return redirect('designation')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $editModeData = Designation::findOrFail($id);
        return view('admin.employee.designation.form',['editModeData' => $editModeData]);
    }


    public function update(DesignationRequest $request,$id) {
        $data = Designation::findOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Designation Successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
         
       $count = Employee::where('designation_id','=',$id)->count();

         if($count>0){

            return  'hasForeignKey';
         }

        try{
            $department = Designation::FindOrFail($id);
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
