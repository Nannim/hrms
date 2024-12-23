<?php

namespace App\Http\Controllers\Performance;

use App\Http\Requests\PerformanceCategoryRequest;

use App\Http\Controllers\Controller;

use App\Model\PerformanceCategory;
use App\Model\PerformanceCriteria;

use Illuminate\Http\Request;


class PerformanceCategoryController extends Controller
{


    public function index()
    {
        $results = PerformanceCategory::all();
        return view('admin.performance.performanceCategory.index',['results' => $results]);
    }


    public function create()
    {
        return view('admin.performance.performanceCategory.form');
    }


    public function store(PerformanceCategoryRequest $request)
    {
        $input = $request->all();
        try{
            PerformanceCategory::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('performanceCategory')->with('success', 'Performance Category Successfully saved.');
        }else {
            return redirect('performanceCategory')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id)
    {
        $editModeData = PerformanceCategory::FindOrFail($id);
        return view('admin.performance.performanceCategory.form',['editModeData' => $editModeData]);
    }


    public function update(PerformanceCategoryRequest $request, $id)
    {
        $data = PerformanceCategory::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Performance Category Successfully Updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
         
         $count = PerformanceCriteria::where('performance_category_id','=',$id)->count();
         if($count>0){
            
            return "hasForeignKey";
         }

        try{
            $data = PerformanceCategory::FindOrFail($id);
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
