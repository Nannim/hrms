<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Requests\AllowanceRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Allowance;


class AllowanceController extends Controller
{

    public function index(){
        $results = Allowance::get();
        return view('admin.payroll.allowance.index',['results' => $results]);
    }



    public function create(){
        return view('admin.payroll.allowance.form');
    }



    public function store(AllowanceRequest $request) {
        $input = $request->all();
        try{
            Allowance::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('allowance')->with('success', 'Allowance Successfully saved.');
        }else {
            return redirect('allowance')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id){
        $editModeData = Allowance::FindOrFail($id);
        return view('admin.payroll.allowance.form',compact('editModeData'));
    }



    public function update(AllowanceRequest $request,$id) {
        $data = Allowance::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Allowance Successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id){
        try{
            $data = Allowance::FindOrFail($id);
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            echo "success";
        }elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }


}
