<?php

Route::group(['middleware' => ['preventbackbutton', 'auth']], function () {

    Route::group(['prefix' => 'taxSetup'], function () {
        Route::get('/', ['as' => 'taxSetup.index', 'uses' => 'Payroll\TaxSetupController@index']);
        Route::post('updateTaxRule', 'Payroll\TaxSetupController@updateTaxRule');
    });

    Route::group(['prefix' => 'salaryDeductionRuleForLateAttendance'], function () {
        Route::get('/', ['as' => 'salaryDeductionRule.index', 'uses' => 'Payroll\SalaryDeductionRuleController@index']);
        Route::post('updateSalaryDeductionRule', 'Payroll\SalaryDeductionRuleController@updateSalaryDeductionRule');
    });

    Route::group(['prefix' => 'allowance'], function () {
        Route::get('/', ['as' => 'allowance.index', 'uses' => 'Payroll\AllowanceController@index']);
        Route::get('/create', ['as' => 'allowance.create', 'uses' => 'Payroll\AllowanceController@create']);
        Route::post('/store', ['as' => 'allowance.store', 'uses' => 'Payroll\AllowanceController@store']);
        Route::get('/{allowance}/edit', ['as' => 'allowance.edit', 'uses' => 'Payroll\AllowanceController@edit']);
        Route::put('/{allowance}', ['as' => 'allowance.update', 'uses' => 'Payroll\AllowanceController@update']);
        Route::delete('/{allowance}/delete', ['as' => 'allowance.delete', 'uses' => 'Payroll\AllowanceController@destroy']);
    });

    Route::group(['prefix' => 'deduction'], function () {
        Route::get('/', ['as' => 'deduction.index', 'uses' => 'Payroll\DeductionController@index']);
        Route::get('/create', ['as' => 'deduction.create', 'uses' => 'Payroll\DeductionController@create']);
        Route::post('/store', ['as' => 'deduction.store', 'uses' => 'Payroll\DeductionController@store']);
        Route::get('/{deduction}/edit', ['as' => 'deduction.edit', 'uses' => 'Payroll\DeductionController@edit']);
        Route::put('/{deduction}', ['as' => 'deduction.update', 'uses' => 'Payroll\DeductionController@update']);
        Route::delete('/{deduction}/delete', ['as' => 'deduction.delete', 'uses' => 'Payroll\DeductionController@destroy']);

    });

    Route::group(['prefix' => 'payGrade'], function () {
        Route::get('/', ['as' => 'payGrade.index', 'uses' => 'Payroll\PayGradeController@index']);
        Route::get('/create', ['as' => 'payGrade.create', 'uses' => 'Payroll\PayGradeController@create']);
        Route::post('/store', ['as' => 'payGrade.store', 'uses' => 'Payroll\PayGradeController@store']);
        Route::get('/{payGrade}/edit', ['as' => 'payGrade.edit', 'uses' => 'Payroll\PayGradeController@edit']);
        Route::put('/{payGrade}', ['as' => 'payGrade.update', 'uses' => 'Payroll\PayGradeController@update']);
        Route::delete('/{payGrade}/delete', ['as' => 'payGrade.delete', 'uses' => 'Payroll\PayGradeController@destroy']);
    });

    Route::group(['prefix' => 'hourlyWages'], function () {
        Route::get('/', ['as' => 'hourlyWages.index', 'uses' => 'Payroll\HourlyWagesPayrollController@index']);
        Route::get('/create', ['as' => 'hourlyWages.create', 'uses' => 'Payroll\HourlyWagesPayrollController@create']);
        Route::post('/store', ['as' => 'hourlyWages.store', 'uses' => 'Payroll\HourlyWagesPayrollController@store']);
        Route::get('/{hourlyWages}/edit', ['as' => 'hourlyWages.edit', 'uses' => 'Payroll\HourlyWagesPayrollController@edit']);
        Route::put('/{hourlyWages}', ['as' => 'hourlyWages.update', 'uses' => 'Payroll\HourlyWagesPayrollController@update']);
        Route::delete('/{hourlyWages}/delete', ['as' => 'hourlyWages.delete', 'uses' => 'Payroll\HourlyWagesPayrollController@destroy']);
    });

    Route::get('generateSalarySheet', ['as' => 'generateSalarySheet.index', 'uses' => 'Payroll\GenerateSalarySheet@index']);
    Route::get('generateSalarySheet/create', ['as' => 'generateSalarySheet.create', 'uses' => 'Payroll\GenerateSalarySheet@create']);
    Route::get('generateSalarySheet/bulk', ['as' => 'generateSalarySheet.bulk', 'uses' => 'Payroll\GenerateSalarySheet@bulkSalary']);
    Route::get('generateSalarySheet/bulk/result', ['as' => 'generateSalarySheet.bulk.result', 'uses' => 'Payroll\GenerateSalarySheet@generateBulkSalary']);
    Route::get('generateSalarySheet/calculateEmployeeSalary', ['as' => 'generateSalarySheet.calculateEmployeeSalary', 'uses' => 'Payroll\GenerateSalarySheet@calculateEmployeeSalary']);
    Route::post('/store', ['as' => 'saveEmployeeSalaryDetails.store', 'uses' => 'Payroll\GenerateSalarySheet@store']);
    Route::post('generateSalarySheet/makePayment', 'Payroll\GenerateSalarySheet@makePayment');
    Route::get('generateSalarySheet/generatePayslip/{id}', 'Payroll\GenerateSalarySheet@generatePayslip');
    Route::get('generateSalarySheet/monthSalary', ['as' => 'generateSalarySheet.monthSalary', 'uses' => 'Payroll\GenerateSalarySheet@monthSalary']);

    Route::get('paymentHistory', ['as' => 'paymentHistory.paymentHistory', 'uses' => 'Payroll\GenerateSalarySheet@paymentHistory']);
    Route::post('paymentHistory', ['as' => 'paymentHistory.paymentHistory', 'uses' => 'Payroll\GenerateSalarySheet@paymentHistory']);
    Route::get('paymentHistory/generatePayslip/{id}', 'Payroll\GenerateSalarySheet@generatePayslip');

    Route::get('myPayroll', ['as' => 'myPayroll.myPayroll', 'uses' => 'Payroll\GenerateSalarySheet@myPayroll']);
    Route::get('myPayroll/generatePayslip/{id}', 'Payroll\GenerateSalarySheet@generatePayslip');

    Route::get('downloadPayslip/{id}', 'Payroll\GenerateSalarySheet@downloadPayslip');
    Route::get('downloadMyPayroll', 'Payroll\GenerateSalarySheet@downloadMyPayroll');

    Route::get('workHourApproval', ['as' => 'workHourApproval.create', 'uses' => 'Payroll\WorkHourApprovalController@create']);
    Route::get('workHourApproval/filter', ['as' => 'workHourApproval.filter', 'uses' => 'Payroll\WorkHourApprovalController@filter']);
    Route::post('workHourApproval', ['as' => 'workHourApproval.store', 'uses' => 'Payroll\WorkHourApprovalController@store']);

    Route::group(['prefix' => 'bonusSetting'], function () {
        Route::get('/', ['as' => 'bonusSetting.index', 'uses' => 'Payroll\BonusSettingController@index']);
        Route::get('/create', ['as' => 'bonusSetting.create', 'uses' => 'Payroll\BonusSettingController@create']);
        Route::post('/store', ['as' => 'bonusSetting.store', 'uses' => 'Payroll\BonusSettingController@store']);
        Route::get('/{bonusSetting}/edit', ['as' => 'bonusSetting.edit', 'uses' => 'Payroll\BonusSettingController@edit']);
        Route::put('/{bonusSetting}', ['as' => 'bonusSetting.update', 'uses' => 'Payroll\BonusSettingController@update']);
        Route::delete('/{bonusSetting}/delete', ['as' => 'bonusSetting.delete', 'uses' => 'Payroll\BonusSettingController@destroy']);
    });

    Route::group(['prefix' => 'generateBonus'], function () {
        Route::get('/', ['as' => 'generateBonus.index', 'uses' => 'Payroll\GenerateBonusController@index']);
        Route::get('/create', ['as' => 'generateBonus.create', 'uses' => 'Payroll\GenerateBonusController@create']);
        Route::post('/store', ['as' => 'saveEmployeeBonus.store', 'uses' => 'Payroll\GenerateBonusController@store']);
        Route::get('/filter', ['as' => 'generateBonus.filter', 'uses' => 'Payroll\GenerateBonusController@filter']);
    });

});
