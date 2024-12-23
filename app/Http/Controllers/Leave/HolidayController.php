<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\HolidayRequest;

use Illuminate\Http\Request;

use App\Model\Holiday;

use App\Http\Controllers\Controller;

class HolidayController extends Controller
{

    public function index(){
        $results = Holiday::orderBy('holiday_id', 'desc')->get();
        return view('admin.leave.holiday.index',['results'=>$results]);
    }


    public function create(){
        return view('admin.leave.holiday.form');
    }


    public function store(HolidayRequest $request){
        $input = $request->all();
        try{
            Holiday::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('manageHoliday')->with('success', 'Holiday successfully saved.');
        }else {
            return redirect('manageHoliday')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $editModeData = Holiday::findOrFail($id);
        return view('admin.leave.holiday.form',['editModeData' => $editModeData]);
    }


    public function update(HolidayRequest $request,$id) {
        $holiday = Holiday::findOrFail($id);
        $input   = $request->all();
        try{
            $holiday->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Holiday successfully updated. ');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
        try{
            $holiday = Holiday::findOrFail($id);
            $holiday->delete();
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
