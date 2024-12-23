<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;

use App\Model\EarnLeaveRule;

use Illuminate\Http\Request;


class EarnLeaveConfigureController extends Controller
{

   public function index(){
       $data = EarnLeaveRule::first();
       return view('admin.leave.setup.earnLeaveConfigure',['data' => $data]);
   }



   public function updateEarnLeaveConfigure(Request $request){
       $input   = $request->all();
       $data = EarnLeaveRule::findOrFail($request->earn_leave_rule_id);

       try{
           $data->update($input);
           $bug = 0;
       }
       catch(\Exception $e){
           $bug = $e->errorInfo[1];
       }

       if($bug==0){
           return "success";
       }else {
           return "error";
       }
   }



}
