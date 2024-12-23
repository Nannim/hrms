<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'manageHoliday'], function () {
        Route::get('/',['as' => 'holiday.index', 'uses'=>'Leave\HolidayController@index']);
        Route::get('/create',['as' => 'holiday.create', 'uses'=>'Leave\HolidayController@create']);
        Route::post('/store',['as' => 'holiday.store', 'uses'=>'Leave\HolidayController@store']);
        Route::get('/{manageHoliday}/edit',['as'=>'holiday.edit','uses'=>'Leave\HolidayController@edit']);
        Route::put('/{manageHoliday}',['as' => 'holiday.update', 'uses'=>'Leave\HolidayController@update']);
        Route::delete('/{manageHoliday}/delete',['as'=>'holiday.delete','uses'=>'Leave\HolidayController@destroy']);
    });

    Route::group(['prefix' => 'publicHoliday'], function () {
        Route::get('/',['as' => 'publicHoliday.index', 'uses'=>'Leave\PublicHolidayController@index']);
        Route::get('/create',['as' => 'publicHoliday.create', 'uses'=>'Leave\PublicHolidayController@create']);
        Route::post('/store',['as' => 'publicHoliday.store', 'uses'=>'Leave\PublicHolidayController@store']);
        Route::get('/{publicHoliday}/edit',['as'=>'publicHoliday.edit','uses'=>'Leave\PublicHolidayController@edit']);
        Route::put('/{publicHoliday}',['as' => 'publicHoliday.update', 'uses'=>'Leave\PublicHolidayController@update']);
        Route::delete('/{publicHoliday}/delete',['as'=>'publicHoliday.delete','uses'=>'Leave\PublicHolidayController@destroy']);
    });

    Route::group(['prefix' => 'weeklyHoliday'], function () {
        Route::get('/',['as' => 'weeklyHoliday.index', 'uses'=>'Leave\WeeklyHolidayController@index']);
        Route::get('/create',['as' => 'weeklyHoliday.create', 'uses'=>'Leave\WeeklyHolidayController@create']);
        Route::post('/store',['as' => 'weeklyHoliday.store', 'uses'=>'Leave\WeeklyHolidayController@store']);
        Route::get('/{weeklyHoliday}/edit',['as'=>'weeklyHoliday.edit','uses'=>'Leave\WeeklyHolidayController@edit']);
        Route::put('/{weeklyHoliday}',['as' => 'weeklyHoliday.update', 'uses'=>'Leave\WeeklyHolidayController@update']);
        Route::delete('/{weeklyHoliday}/delete',['as'=>'weeklyHoliday.delete','uses'=>'Leave\WeeklyHolidayController@destroy']);
    });

    Route::group(['prefix' => 'leaveType'], function () {
        Route::get('/',['as' => 'leaveType.index', 'uses'=>'Leave\LeaveTypeController@index']);
        Route::get('/create',['as' => 'leaveType.create', 'uses'=>'Leave\LeaveTypeController@create']);
        Route::post('/store',['as' => 'leaveType.store', 'uses'=>'Leave\LeaveTypeController@store']);
        Route::get('/{leaveType}/edit',['as'=>'leaveType.edit','uses'=>'Leave\LeaveTypeController@edit']);
        Route::put('/{leaveType}',['as' => 'leaveType.update', 'uses'=>'Leave\LeaveTypeController@update']);
        Route::delete('/{leaveType}/delete',['as'=>'leaveType.delete','uses'=>'Leave\LeaveTypeController@destroy']);
    });

    Route::group(['prefix' => 'applyForLeave'], function () {
        Route::get('/',['as' => 'applyForLeave.index', 'uses'=>'Leave\ApplyForLeaveController@index']);
        Route::get('/create',['as' => 'applyForLeave.create', 'uses'=>'Leave\ApplyForLeaveController@create']);
        Route::post('/store',['as' => 'applyForLeave.store', 'uses'=>'Leave\ApplyForLeaveController@store']);
        Route::post('getEmployeeLeaveBalance','Leave\ApplyForLeaveController@getEmployeeLeaveBalance');
        Route::post('applyForTotalNumberOfDays','Leave\ApplyForLeaveController@applyForTotalNumberOfDays');
        Route::get('/{applyForLeave}',['as'=>'applyForLeave.show','uses'=>'ApplyForLeaveController\applyForTotalNumberOfDays@show']);
    });

    Route::group(['prefix' => 'earnLeaveConfigure'], function () {
        Route::get('/',['as' => 'earnLeaveConfigure.index', 'uses'=>'Leave\EarnLeaveConfigureController@index']);
        Route::post('updateEarnLeaveConfigure','Leave\EarnLeaveConfigureController@updateEarnLeaveConfigure');
    });


    Route::group(['prefix' => 'requestedApplication'], function () {
        Route::get('/',['as' => 'requestedApplication.index', 'uses'=>'Leave\RequestedApplicationController@index']);
        Route::get('/{requestedApplication}/viewDetails',['as'=>'requestedApplication.viewDetails','uses'=>'Leave\RequestedApplicationController@viewDetails']);
        Route::put('/{requestedApplication}',['as' => 'requestedApplication.update', 'uses'=>'Leave\RequestedApplicationController@update']);
    });

    Route::get('leaveReport',['as' => 'leaveReport.leaveReport', 'uses'=>'Leave\ReportController@employeeLeaveReport']);
    Route::post('leaveReport',['as' => 'leaveReport.leaveReport', 'uses'=>'Leave\ReportController@employeeLeaveReport']);
    Route::get('downloadLeaveReport','Leave\ReportController@downloadLeaveReport');

    Route::get('summaryReport',['as' => 'summaryReport.summaryReport', 'uses'=>'Leave\ReportController@summaryReport']);
    Route::post('summaryReport',['as' => 'summaryReport.summaryReport', 'uses'=>'Leave\ReportController@summaryReport']);
    Route::get('downloadSummaryReport','Leave\ReportController@downloadSummaryReport');


    Route::get('myLeaveReport',['as' => 'myLeaveReport.myLeaveReport', 'uses'=>'Leave\ReportController@myLeaveReport']);
    Route::post('myLeaveReport',['as' => 'myLeaveReport.myLeaveReport', 'uses'=>'Leave\ReportController@myLeaveReport']);
    Route::get('downloadMyLeaveReport','Leave\ReportController@downloadMyLeaveReport');

    Route::post('approveOrRejectLeaveApplication','Leave\RequestedApplicationController@approveOrRejectLeaveApplication');


});

