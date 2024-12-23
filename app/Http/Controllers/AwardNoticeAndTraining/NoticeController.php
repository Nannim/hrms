<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Http\Controllers\Controller;

use App\Http\Requests\NoticeRequest;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Model\Notice;


class NoticeController extends Controller
{


    public function index(){
        $results = Notice::orderBy('notice_id','DESC')->get();
        return view('admin.notice.index',['results' => $results]);
    }



    public function create(){
        return view('admin.notice.form');
    }



    public function store(NoticeRequest $request) {
		
		$file 	= $request->file('attach_file');
        $input  = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;
        $input['publish_date'] = dateConvertFormtoDB($request->publish_date);
        
        if($file){
            $fileName = md5(str_random(30).time().'_'.$request->file('attach_file')).'.'.$request->file('attach_file')->getClientOriginalExtension();
            $request->file('attach_file')->move('uploads/notice/',$fileName);
            $input['attach_file'] = $fileName;
        }
		
        try{
            Notice::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('notice')->with('success', 'Notice Successfully saved.');
        }else {
            return redirect('notice')->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function show($id){
        $editModeData = Notice::with('createdBy')->where('notice_id',$id)->first();
        return view('admin.notice.details',compact('editModeData'));
    }



    public function edit($id){
        $editModeData = Notice::FindOrFail($id);
        return view('admin.notice.form',compact('editModeData'));
    }



    public function update(NoticeRequest $request,$id) {
		
		$file = $request->file('attach_file');
        $data = Notice::FindOrFail($id);
        $input = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;
        $input['publish_date'] = dateConvertFormtoDB($request->publish_date);

        
        if($file){
            $fileName = md5(str_random(30).time().'_'.$request->file('attach_file')).'.'.$request->file('attach_file')->getClientOriginalExtension();
            $request->file('attach_file')->move('uploads/notice/',$fileName);
            if(file_exists('uploads/notice/'.$data->attach_file) AND !empty($data->attach_file)){
                unlink('uploads/notice/'.$data->attach_file);
            }
            $input['attach_file'] = $fileName;
        }

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Notice Successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function destroy($id){
        try{
            $data = Notice::FindOrFail($id);
            if (!is_null($data->attach_file))
            {
                if(file_exists('uploads/notice/'.$data->attach_file) AND !empty($data->attach_file))
                {
                    unlink('uploads/notice/'.$data->attach_file);
                }
            }
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
