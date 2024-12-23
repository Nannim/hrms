<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Requests\BonusSettingRequest;

use App\Http\Controllers\Controller;

use App\Model\BonusSetting;

use Illuminate\Http\Request;


class BonusSettingController extends Controller
{

    public function index(){
        $results = BonusSetting::get();
        return view('admin.payroll.bonusSetting.index',['results' => $results]);
    }


    public function create(){
        return view('admin.payroll.bonusSetting.form');
    }


    public function store(BonusSettingRequest $request){
        $input = $request->all();
        try{
            BonusSetting::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('bonusSetting')->with('success', 'Bonus successfully saved.');
        }else {
            return redirect('bonusSetting')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $editModeData = BonusSetting::FindOrFail($id);
        return view('admin.payroll.bonusSetting.form',compact('editModeData'));
    }


    public function update(BonusSettingRequest $request,$id) {
        $data = BonusSetting::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Bonus successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
        try{
            $data = BonusSetting::FindOrFail($id);
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
