<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\EmployeeAttendance;

class ApiAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     

       try{

        $this->validate($request,
         [

          'finger_id' => 'required',
          
         ]
        );

        $finger_id = $request->finger_id;
        $in_out_time = $request->in_out_time ? $request->in_out_time : date("Y-m-d H:i:s");
        $check = Employee::where('finger_id',$finger_id)->where('status','=',1)->count();

        if($check <= 0){
         
            return response()->json(['status' => 400,'message'=>'Employee Information not found or  employee not registered in payroll software']);

        }
        else{
            
            $att = new EmployeeAttendance;

            $att->finger_print_id = $finger_id;
            $att->in_out_time = date("Y-m-d H:i:s", strtotime($in_out_time));

            $att->save();

            return response()->json(['status' => 202,'message'=>'Employee attendnance updated']);




        }

       }
       catch(\Exception $e){
        
        return $e;

       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
