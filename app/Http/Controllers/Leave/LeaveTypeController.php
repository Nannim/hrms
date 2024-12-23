<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\LeaveTypeRequest;

use App\Http\Controllers\Controller;

use App\Model\LeaveType;
use App\Model\LeaveApplication;

use Illuminate\Http\Request;


class LeaveTypeController extends Controller
{
	
    public function index(){
        $results = LeaveType::OrderBy('leave_type_id','desc')->where('leave_type_id','!=',1)->get();
        return view('admin.leave.leaveType.index',['results'=>$results]);
    }


    public function create(){
        return view('admin.leave.leaveType.form');
    }


    public function store(LeaveTypeRequest $request){
        $input = $request->all();
        try{
            LeaveType::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('leaveType')->with('success', 'Leave Type successfully saved.');
        }else {
            return redirect('leaveType')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $editModeData = LeaveType::findOrFail($id);
        return view('admin.leave.leaveType.form',['editModeData' => $editModeData]);
    }


    public function update(LeaveTypeRequest $request,$id) {
        $data   = LeaveType::findOrFail($id);
        $input  = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Leave Type successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
           
     $count = LeaveApplication::where('leave_type_id','=',$id)->count();

        if ($count>0) {
          return "hasForeignKey";
        }

        try{
            $data = LeaveType::findOrFail($id);
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
