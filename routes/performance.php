<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'performanceCategory'], function () {
        Route::get('/',['as' => 'performanceCategory.index', 'uses'=>'Performance\PerformanceCategoryController@index']);
        Route::get('/create',['as' => 'performanceCategory.create', 'uses'=>'Performance\PerformanceCategoryController@create']);
        Route::post('/store',['as' => 'performanceCategory.store', 'uses'=>'Performance\PerformanceCategoryController@store']);
        Route::get('/{performanceCategoryId}/edit',['as'=>'performanceCategory.edit','uses'=>'Performance\PerformanceCategoryController@edit']);
        Route::put('/{performanceCategoryId}',['as' => 'performanceCategory.update', 'uses'=>'Performance\PerformanceCategoryController@update']);
        Route::delete('/{performanceCategoryId}/delete',['as'=>'performanceCategory.delete','uses'=>'Performance\PerformanceCategoryController@destroy']);
    });

    Route::group(['prefix' => 'performanceCriteria'], function () {
        Route::get('/',['as' => 'performanceCriteria.index', 'uses'=>'Performance\PerformanceCriteriaController@index']);
        Route::get('/create',['as' => 'performanceCriteria.create', 'uses'=>'Performance\PerformanceCriteriaController@create']);
        Route::post('/store',['as' => 'performanceCriteria.store', 'uses'=>'Performance\PerformanceCriteriaController@store']);
        Route::get('/{performanceCriteriaId}/edit',['as'=>'performanceCriteria.edit','uses'=>'Performance\PerformanceCriteriaController@edit']);
        Route::put('/{performanceCriteriaId}',['as' => 'performanceCriteria.update', 'uses'=>'Performance\PerformanceCriteriaController@update']);
        Route::delete('/{performanceCriteriaId}/delete',['as'=>'performanceCriteria.delete','uses'=>'Performance\PerformanceCriteriaController@destroy']);
    });

    Route::group(['prefix' => 'empPerformance'], function () {
        Route::get('/',['as' => 'employeePerformance.index', 'uses'=>'Performance\EmployeePerformanceController@index']);
        Route::get('/create',['as' => 'employeePerformance.create', 'uses'=>'Performance\EmployeePerformanceController@create']);
        Route::post('/store',['as' => 'employeePerformance.store', 'uses'=>'Performance\EmployeePerformanceController@store']);
        Route::get('/{employeePerformanceId}/edit',['as'=>'employeePerformance.edit','uses'=>'Performance\EmployeePerformanceController@edit']);
        Route::put('/{employeePerformanceId}',['as' => 'employeePerformance.update', 'uses'=>'Performance\EmployeePerformanceController@update']);
        Route::delete('/{employeePerformanceId}/delete',['as'=>'employeePerformance.delete','uses'=>'Performance\EmployeePerformanceController@destroy']);
        Route::get('/{id}',['as' => 'employeePerformance.show', 'uses'=>'Performance\EmployeePerformanceController@show']);
    });

    Route::group(['prefix' => 'promotion'], function () {
        Route::get('/',['as' => 'promotion.index', 'uses'=>'Performance\PromotionController@index']);
        Route::get('/create',['as' => 'promotion.create', 'uses'=>'Performance\PromotionController@create']);
        Route::post('/store',['as' => 'promotion.store', 'uses'=>'Performance\PromotionController@store']);
        Route::get('/{promotion}/edit',['as'=>'promotion.edit','uses'=>'Performance\PromotionController@edit']);
        Route::put('/{promotion}',['as' => 'promotion.update', 'uses'=>'Performance\PromotionController@update']);
        Route::delete('/{promotion}/delete',['as'=>'promotion.delete','uses'=>'Performance\PromotionController@destroy']);
        Route::post('/findEmployeeInfo','Performance\PromotionController@findEmployeeInfo');
        Route::post('/findPayGradeWiseSalary','Performance\PromotionController@findPayGradeWiseSalary');
    });

    Route::get('performanceSummaryReport',['as' => 'performanceSummaryReport.performanceSummaryReport', 'uses'=>'Performance\PerformanceReportController@performanceSummaryReport']);
    Route::post('performanceSummaryReport',['as' => 'performanceSummaryReport.performanceSummaryReport', 'uses'=>'Performance\PerformanceReportController@performanceSummaryReport']);

    Route::get('downloadPerformanceSummaryReport','Performance\PerformanceReportController@downloadPerformanceSummaryReport');


});

