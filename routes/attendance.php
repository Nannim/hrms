<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'workShift'], function () {
        Route::get('/',['as' => 'workShift.index', 'uses'=>'Attendance\WorkShiftController@index']);
        Route::get('/create',['as' => 'workShift.create', 'uses'=>'Attendance\WorkShiftController@create']);
        Route::post('/store',['as' => 'workShift.store', 'uses'=>'Attendance\WorkShiftController@store']);
        Route::get('/{workShift}/edit',['as'=>'workShift.edit','uses'=>'Attendance\WorkShiftController@edit']);
        Route::put('/{workShift}',['as' => 'workShift.update', 'uses'=>'Attendance\WorkShiftController@update']);
        Route::delete('/{workShift}/delete',['as'=>'workShift.delete','uses'=>'Attendance\WorkShiftController@destroy']);
    });

    Route::get('dailyAttendance',['as' => 'dailyAttendance.dailyAttendance', 'uses'=>'Attendance\AttendanceReportController@dailyAttendance']);
    Route::post('dailyAttendance',['as' => 'dailyAttendance.dailyAttendance', 'uses'=>'Attendance\AttendanceReportController@dailyAttendance']);
    Route::get('monthlyAttendance',['as' => 'monthlyAttendance.monthlyAttendance', 'uses'=>'Attendance\AttendanceReportController@monthlyAttendance']);
    Route::post('monthlyAttendance',['as' => 'monthlyAttendance.monthlyAttendance', 'uses'=>'Attendance\AttendanceReportController@monthlyAttendance']);

    Route::get('myAttendanceReport',['as' => 'myAttendanceReport.myAttendanceReport', 'uses'=>'Attendance\AttendanceReportController@myAttendanceReport']);
    Route::post('myAttendanceReport',['as' => 'myAttendanceReport.myAttendanceReport', 'uses'=>'Attendance\AttendanceReportController@myAttendanceReport']);

    Route::get('attendanceSummaryReport',['as' => 'attendanceSummaryReport.attendanceSummaryReport', 'uses'=>'Attendance\AttendanceReportController@attendanceSummaryReport']);
    Route::post('attendanceSummaryReport',['as' => 'attendanceSummaryReport.attendanceSummaryReport', 'uses'=>'Attendance\AttendanceReportController@attendanceSummaryReport']);

    Route::get('manualAttendance',['as' => 'manualAttendance.manualAttendance', 'uses'=>'Attendance\ManualAttendanceController@manualAttendance']);
    Route::get('manualAttendance/filter',['as' => 'manualAttendance.filter', 'uses'=>'Attendance\ManualAttendanceController@filterData']);
    Route::post('manualAttendanceStore',['as' => 'manualAttendance.store', 'uses'=>'Attendance\ManualAttendanceController@store']);

    Route::get('downloadDailyAttendance/{id}','Attendance\AttendanceReportController@downloadDailyAttendance');
    Route::get('downloadMonthlyAttendance','Attendance\AttendanceReportController@downloadMonthlyAttendance');
    Route::get('downloadMyAttendance','Attendance\AttendanceReportController@downloadMyAttendance');
    Route::get('downloadAttendanceSummaryReport/{date}','Attendance\AttendanceReportController@downloadAttendanceSummaryReport');


    // get attendance by ip 

    Route::post('ip-attendance',['as' => 'ip.attendance','uses' => 'Attendance\ManualAttendanceController@ipAttendance']);

    // setup ip  attendance 

    Route::get('setup-employee-attendance',['as' => 'attendance.dashboard' , 'uses' => 'Attendance\ManualAttendanceController@setupDashboardAttendance']);    

    Route::post('setup-employee-attendance-post',['as' => 'attendance.dashboard.post' , 'uses' => 'Attendance\ManualAttendanceController@postDashboardAttendance']);


});

