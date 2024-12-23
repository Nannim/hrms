<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use App\Lib\Enumerations\JobStatus;
use App\Model\Job;
use App\Model\JobApplicant;
use App\Model\Services;
use Dotenv\Validator;
use Exception;

class WebController extends Controller
{
    //

    public function index(Request $request)
    {
        $published = 1;
        $active = 1;
        $job = Job::where('status','=',$published)
                    ->where('application_end_date','>=',date('Y-m-d'))
                    ->orderBy('updated_at','desc')
                    ->paginate(5);
         
         

         
         if(request()->ajax())
         {

            $job = Job::where('status','=',$published)
            ->where('application_end_date','>=',date('Y-m-d'))
            ->paginate(5);

            return   \View('front.job_pagination', ['jobs' => $job])->render();
         }
         
        $services = Services::where('status','=',$active)->get();   
        return view('front.index',['jobs' => $job,'services' => $services]);
    }


    public function jobDetails($id,$slug)
    {
        $job = Job::find($id);

        return view('front.job_details',['job' => $job]);
    }

    public function jobApply(JobApplicationRequest $request)
    {

        try
        {
            $applicant = new JobApplicant;
            $applicant->job_id = $request->job_id;
            $applicant->applicant_name = $request->name;
            $applicant->applicant_email = $request->email;
            $applicant->phone = $request->phone;
            $applicant->cover_letter = $request->cover_letter;
            $applicant->application_date = date('Y-m-d');
            $applicant->status = JobStatus::$Apply;
            
            $resume = $request->file('resume');

            if($resume)
            {
              $file_name = str_replace(' ','-',$request->name).'-'.time().'.'.$resume->getClientOriginalExtension();
              $resume->move('uploads/applicantResume/',$file_name);
              $applicant->attached_resume = $file_name;
            }

            $applicant->save();
            
          
            return redirect()->back()->with('success','Application Successful');
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }    

    }
}
