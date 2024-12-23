<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Requests\JobPostRequest;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Job;


class JobPostController extends Controller
{

    public function index()
	{
        $results = Job::with('createdBy')->orderBy('job_id','DESC')->paginate(10);
        return view('admin.recruitment.job.index',['results'=>$results]);
    }



    public function create()
	{
        return view('admin.recruitment.job.form');
    }



    public function store(JobPostRequest $request) 
	{
        $input 							= $request->all();
        $input['created_by'] 			= Auth::user()->user_id;
        $input['updated_by'] 			= Auth::user()->user_id;
        $input['application_end_date']  = dateConvertFormtoDB($request->application_end_date);

        try{
            Job::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('jobPost')->with('success', 'Job successfully created.');
        }else {
            return redirect('jobPost')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function edit($id)
	{
        $editModeData = Job::findOrFail($id);
        return view('admin.recruitment.job.form',['editModeData'=>$editModeData]);
    }



    public function show($id)
	{
        $results = Job::with(['createdBy'])->where('job_id',$id)->first();
        return view('admin.recruitment.job.details',['result' => $results]);
    }



    public function update(JobPostRequest $request,$id) 
	{
        $data 							= Job::findOrFail($id);
        $input 							= $request->all();
        $input['created_by'] 			= Auth::user()->user_id;
        $input['updated_by'] 			= Auth::user()->user_id;
        $input['application_end_date']  = dateConvertFormtoDB($request->application_end_date);

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Job successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id)
    {
        try{
            $data = Job::FindOrFail($id);
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
