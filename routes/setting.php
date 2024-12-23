<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'generalSettings'], function () {
    Route::get('/',['as' => 'generalSettings.index', 'uses'=>'Setting\GeneralSettingController@index']);
    Route::post('/',['as' => 'generalSettings.store', 'uses'=>'Setting\GeneralSettingController@store']);
    Route::get('/{generalSettings}/edit',['as'=>'generalSettings.edit','uses'=>'Setting\GeneralSettingController@edit']);
    Route::put('/{generalSettings}',['as' => 'generalSettings.update', 'uses'=>'Setting\GeneralSettingController@update']);
    Route::post('printHeadSettings',['as' => 'printHeadSettings.store', 'uses'=>'Setting\GeneralSettingController@printHeadSettingsStore']);
    Route::put('printHeadSettings/{id}',['as' => 'printHeadSettings.update', 'uses'=>'Setting\GeneralSettingController@printHeadSettingsUpdate']);

    });

    // front end setting 
    Route::resource('service', 'Setting\ServicesController');
    // front end settings control
    Route::get('setting-front-page','Setting\FrontSettingController@index')->name('front.setting');
    Route::post('setting-front-page','Setting\FrontSettingController@store')->name('front.setting.submit');
});

