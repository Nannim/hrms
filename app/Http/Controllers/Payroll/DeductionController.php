<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Requests\DeductionRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Deduction;


class DeductionController extends Controller
{

    public function index()
    {
        $results = Deduction::get();
        return view('admin.payroll.deduction.index',['results'=>$results]);
    }



    public function create()
    {
        return view('admin.payroll.deduction.form');
    }



    public function store(DeductionRequest $request)
    {
        $input = $request->all();
        try{
            Deduction::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('deduction')->with('success', 'Deduction Successfully saved.');
        }else {
            return redirect('deduction')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id)
    {
        $editModeData = Deduction::findOrFail($id);
        return view('admin.payroll.deduction.form',['editModeData' => $editModeData]);
    }



    public function update(DeductionRequest $request, $id)
    {
        $data = Deduction::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Deduction Successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id)
    {
        try{
            $data = Deduction::FindOrFail($id);
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
