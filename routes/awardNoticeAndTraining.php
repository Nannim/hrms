<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'award'], function () {
        Route::get('/',['as' => 'award.index', 'uses'=>'AwardNoticeAndTraining\AwardController@index']);
        Route::get('/create',['as' => 'award.create', 'uses'=>'AwardNoticeAndTraining\AwardController@create']);
        Route::post('/',['as' => 'award.store', 'uses'=>'AwardNoticeAndTraining\AwardController@store']);
        Route::get('/{award}/edit',['as'=>'award.edit','uses'=>'AwardNoticeAndTraining\AwardController@edit']);
        Route::put('/{award}',['as' => 'award.update', 'uses'=>'AwardNoticeAndTraining\AwardController@update']);
        Route::delete('/{award}/delete',['as'=>'award.delete','uses'=>'AwardNoticeAndTraining\AwardController@destroy']);
    });

    Route::group(['prefix' => 'notice'], function () {
        Route::get('/',['as' => 'notice.index', 'uses'=>'AwardNoticeAndTraining\NoticeController@index']);
        Route::get('/create',['as' => 'notice.create', 'uses'=>'AwardNoticeAndTraining\NoticeController@create']);
        Route::post('/',['as' => 'notice.store', 'uses'=>'AwardNoticeAndTraining\NoticeController@store']);
        Route::get('/{notice}',['as'=>'notice.show','uses'=>'AwardNoticeAndTraining\NoticeController@show']);
        Route::get('/{notice}/edit',['as'=>'notice.edit','uses'=>'AwardNoticeAndTraining\NoticeController@edit']);
        Route::put('/{notice}',['as' => 'notice.update', 'uses'=>'AwardNoticeAndTraining\NoticeController@update']);
        Route::delete('/{notice}/delete',['as'=>'notice.delete','uses'=>'AwardNoticeAndTraining\NoticeController@destroy']);
    });

    Route::group(['prefix' => 'trainingType'], function () {
        Route::get('/',['as' => 'trainingType.index', 'uses'=>'AwardNoticeAndTraining\TrainingTypeController@index']);
        Route::get('/create',['as' => 'trainingType.create', 'uses'=>'AwardNoticeAndTraining\TrainingTypeController@create']);
        Route::post('/',['as' => 'trainingType.store', 'uses'=>'AwardNoticeAndTraining\TrainingTypeController@store']);
        Route::get('/{trainingType}',['as'=>'trainingType.show','uses'=>'AwardNoticeAndTraining\TrainingTypeController@show']);
        Route::get('/{trainingType}/edit',['as'=>'trainingType.edit','uses'=>'AwardNoticeAndTraining\TrainingTypeController@edit']);
        Route::put('/{trainingType}',['as' => 'trainingType.update', 'uses'=>'AwardNoticeAndTraining\TrainingTypeController@update']);
        Route::delete('/{trainingType}/delete',['as'=>'trainingType.delete','uses'=>'AwardNoticeAndTraining\TrainingTypeController@destroy']);
    });

    Route::group(['prefix' => 'trainingInfo'], function () {
        Route::get('/',['as' => 'trainingInfo.index', 'uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@index']);
        Route::get('/create',['as' => 'trainingInfo.create', 'uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@create']);
        Route::post('/',['as' => 'trainingInfo.store', 'uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@store']);
        Route::get('/{trainingInfo}',['as'=>'trainingInfo.show','uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@show']);
        Route::get('/{trainingInfo}/edit',['as'=>'trainingInfo.edit','uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@edit']);
        Route::put('/{trainingInfo}',['as' => 'trainingInfo.update', 'uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@update']);
        Route::delete('/{trainingInfo}/delete',['as'=>'trainingInfo.delete','uses'=>'AwardNoticeAndTraining\EmployeeTrainingController@destroy']);
    });


    Route::get('trainingReport',['as' => 'employeeTrainingReport.employeeTrainingReport', 'uses'=>'AwardNoticeAndTraining\TrainingReportController@employeeTrainingReport']);
    Route::post('trainingReport',['as' => 'employeeTrainingReport.employeeTrainingReport', 'uses'=>'AwardNoticeAndTraining\TrainingReportController@employeeTrainingReport']);
    Route::get('downloadTrainingReport','AwardNoticeAndTraining\TrainingReportController@downloadTrainingReport');

});

