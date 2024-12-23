<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Http\Requests\TrainingTypeRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\TrainingType;

use App\Model\TrainingInfo;



class TrainingTypeController extends Controller
{


    public function index()
    {
        $results = TrainingType::orderBy('training_type_id','DESC')->get();
        return view('admin.training.trainingType.index',['results' => $results]);
    }



    public function create()
    {
        return view('admin.training.trainingType.form');
    }



    public function store(TrainingTypeRequest $request)
    {
        $input = $request->all();

        try{
            TrainingType::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('trainingType')->with('success', 'Training type successfully saved.');
        }else {
            return redirect('trainingType')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id)
    {
        $editModeData = TrainingType::FindOrFail($id);
        return view('admin.training.trainingType.form',compact('editModeData'));
    }



    public function update(TrainingTypeRequest $request,$id)
    {
        $data = TrainingType::FindOrFail($id);
        $input = $request->all();

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Training type successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id)
    {
        try{
            $data = TrainingType::FindOrFail($id);
            $data->delete();
            TrainingInfo::where('training_type_id','=',$id)->delete();
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
