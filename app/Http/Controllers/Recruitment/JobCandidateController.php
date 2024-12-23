<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Requests\JobInterviewRequest;

use App\Http\Controllers\Controller;

use App\Lib\Enumerations\JobStatus;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Model\JobApplicant;

use App\Model\Interview;

use App\Model\Job;


class JobCandidateController extends Controller
{

    public $perPage = 10;

    public function index()
    {
        $results = Job::select('job.*',
                            DB::raw('(select count(job_applicant_id) from job_applicant where (status = '.JobStatus::$SHORTLIST.' or status = '.JobStatus::$CALL_FOR_INTERVIEW.') and job.job_id = job_applicant.job_id) as shortList'),
                            DB::raw('(select count(job_applicant_id) from job_applicant where status = '.JobStatus::$REJECT.' and job.job_id = job_applicant.job_id) as reject'),
							DB::raw('(select count(job_applicant_id) from job_applicant where job.job_id = job_applicant.job_id) as totalApplication'),
							DB::raw('(SELECT COUNT(job_applicant_id) FROM job_applicant WHERE status = '.JobStatus::$CALL_FOR_INTERVIEW.' AND job.job_id = job_applicant.job_id) AS interview')
                        )
                    ->orderBy('job_id','DESC')->paginate($this->perPage);
        return view('admin.recruitment.jobCandidate.index',['results' => $results]);
    }

	

    public function applyCandidateList($id)
	{
        $job     = Job::where('job_id',$id)->first();
        $results = JobApplicant::with('job')->where('job_id',$id)->orderBy('status','ASC')->orderBy('job_applicant_id','DESC')->paginate($this->perPage);
        return view('admin.recruitment.jobCandidate.applyCandidateList',['results' => $results,'job' => $job]);
    }


	
    public function shortlist($id)
	{
        try{
            JobApplicant::where('job_applicant_id',$id)->update(['status' => JobStatus::$SHORTLIST]);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Job application shortListed.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }

	

    public function reject($id)
	{
        try{
            JobApplicant::where('job_applicant_id',$id)->update(['status' => JobStatus::$REJECT]);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Job application rejected.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function shortListedApplicant($id)
	{
        $job     = Job::where('job_id',$id)->first();
        $results = JobApplicant::where('job_id',$id)
                    ->where(function ($query) {
                        $query->where('status', JobStatus::$SHORTLIST)->orWhere('status',JobStatus::$CALL_FOR_INTERVIEW);
                    })
                    ->orderBy('status','ASC')
                    ->paginate($this->perPage);
					
        return view('admin.recruitment.jobCandidate.shortListedApplicant',['results' => $results,'job' => $job]);
    }



    public function jobInterview($id)
	{
        $results = JobApplicant::with('job')->where('job_applicant_id',$id)->where('status',JobStatus::$SHORTLIST)->first();
        return view('admin.recruitment.jobCandidate.callForInterview',['results' => $results]);
    }



    public function jobInterviewStore(JobInterviewRequest $request,$id)
	{

        $input 						= $request->all();
        $input['job_applicant_id'] 	= $id;
        $input['interview_time'] 	= date("H:i:s", strtotime($request->interview_time));
        $input['interview_date']	= dateConvertFormtoDB($request->interview_date);

        try{
            DB::beginTransaction();

                Interview::create($input);
                $data = JobApplicant::where('job_applicant_id',$id)->first();
                $data->update(['status' => JobStatus::$CALL_FOR_INTERVIEW]);

            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('jobCandidate/shortListedApplicant/'.$data->job_id)->with('success', 'Job interview added.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }

    }



    public function rejectedApplicant($id)
	{
        $job     = Job::where('job_id',$id)->first();
        $results = JobApplicant::where('job_id',$id)->where('status',JobStatus::$REJECT)->paginate($this->perPage);
        return view('admin.recruitment.jobCandidate.rejectedApplicant',['results' => $results,'job' => $job]);
    }



    public function jobInterviewList($id)
	{
        $job     = Job::where('job_id',$id)->first();
        $results = JobApplicant::with('interviewInfo')->where('job_id',$id)->where('status',JobStatus::$CALL_FOR_INTERVIEW)->paginate($this->perPage);
        return view('admin.recruitment.jobCandidate.interviewList',['results' => $results,'job' => $job]);
    }


}
