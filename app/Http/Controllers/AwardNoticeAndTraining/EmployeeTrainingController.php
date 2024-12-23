<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Http\Requests\EmployeeTrainingRequest;

use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Model\TrainingInfo;

use Illuminate\Http\Request;



class EmployeeTrainingController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository)
	{
        $this->commonRepository = $commonRepository;
    }



    public function index()
    {
        $results = TrainingInfo::with(['employee','trainingType'])->orderBy('training_info_id','DESC')->get();
        return view('admin.training.employeeTraining.index',['results' => $results]);
    }



    public function create()
    {
        $employeeList      = $this->commonRepository->employeeList();
        $trainingTypeList  = $this->commonRepository->trainingTypeList();
        return view('admin.training.employeeTraining.form',['employeeList' => $employeeList,'trainingTypeList' => $trainingTypeList]);
    }



    public function store(EmployeeTrainingRequest $request)
    {
        $input = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;
        $input['start_date'] = dateConvertFormtoDB($request->start_date);
        $input['end_date'] = dateConvertFormtoDB($request->end_date);

        $photo = $request->file('certificate');

        if($photo){
            $fileName = md5(str_random(30).time().'_'.$request->file('certificate')).'.'.$request->file('certificate')->getClientOriginalExtension();
            $request->file('certificate')->move('uploads/employeeTrainingCertificate/',$fileName);
            $input['certificate'] = $fileName;
        }

        try{
            TrainingInfo::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('trainingInfo')->with('success', 'Employee training successfully saved.');
        }else {
            return redirect('trainingInfo')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id)
    {
        $editModeData = TrainingInfo::FindOrFail($id);
        $employeeList      = $this->commonRepository->employeeList();
        $trainingTypeList  = $this->commonRepository->trainingTypeList();
        return view('admin.training.employeeTraining.form',['employeeList' => $employeeList,'trainingTypeList' => $trainingTypeList,'editModeData' => $editModeData]);
    }



    public function update(EmployeeTrainingRequest $request,$id)
    {
        $photo = $request->file('certificate');
        $data = TrainingInfo::FindOrFail($id);

        $input = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;
        $input['start_date'] = dateConvertFormtoDB($request->start_date);
        $input['end_date'] = dateConvertFormtoDB($request->end_date);

        if($photo){
            $fileName = md5(str_random(30).time().'_'.$request->file('certificate')).'.'.$request->file('certificate')->getClientOriginalExtension();
            $request->file('certificate')->move('uploads/employeeTrainingCertificate/',$fileName);
            if(file_exists('uploads/employeeTrainingCertificate/'.$data->certificate) AND !empty($data->certificate)){
                unlink('uploads/employeeTrainingCertificate/'.$data->certificate);
            }
            $input['certificate'] = $fileName;
        }

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Employee training successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function show($id)
    {
        $result = TrainingInfo::with(['employee','trainingType'])->where('training_info_id',$id)->first();
        return view('admin.training.employeeTraining.details',['result' => $result]);
    }



    public function destroy($id)
    {
        try
        {
            $data = TrainingInfo::FindOrFail($id);

            if (!is_null($data->certificate))
            {
                if(file_exists('uploads/employeeTrainingCertificate/'.$data->certificate) AND !empty($data->certificate))
                {
                    unlink('uploads/employeeTrainingCertificate/'.$data->certificate);
                }
            }
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e)
        {
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
