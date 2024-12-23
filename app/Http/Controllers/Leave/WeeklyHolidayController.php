<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\WeeklyHolidayRequest;

use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use App\Model\WeeklyHoliday;

use Illuminate\Http\Request;


class WeeklyHolidayController extends Controller
{
	
    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository){
        $this->commonRepository = $commonRepository;
    }


    public function index(){
        $results = WeeklyHoliday::get();
        return view('admin.leave.weeklyHoliday.index',['results'=>$results]);
    }


    public function create(){
        $weekList = $this->commonRepository->weekList();
        return view('admin.leave.weeklyHoliday.form', ['weekList' => $weekList]);
    }


    public function store(WeeklyHolidayRequest $request){
        $input = $request->all();
        try{
            WeeklyHoliday::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('weeklyHoliday')->with('success', 'Weekly holiday successfully saved.');
        }else {
            return redirect('weeklyHoliday')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $weekList       = $this->commonRepository->weekList();
        $editModeData   = WeeklyHoliday::findOrFail($id);
        return view('admin.leave.weeklyHoliday.form', ['editModeData'=> $editModeData,'weekList' => $weekList]);
    }


    public function update(WeeklyHolidayRequest $request,$id) {
        $input  = $request->all();
        $data   = WeeklyHoliday::findOrFail($id);
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Weekly holiday successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
        try{
            $data = WeeklyHoliday::findOrFail($id);
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
