<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'jobPost'], function () {
        Route::get('/',['as' => 'jobPost.index', 'uses'=>'Recruitment\JobPostController@index']);
        Route::get('/create',['as' => 'jobPost.create', 'uses'=>'Recruitment\JobPostController@create']);
        Route::post('/store',['as' => 'jobPost.store', 'uses'=>'Recruitment\JobPostController@store']);
        Route::get('/{jobPostID}',['as'=>'jobPost.show','uses'=>'Recruitment\JobPostController@show']);
        Route::get('/{jobPostID}/edit',['as'=>'jobPost.edit','uses'=>'Recruitment\JobPostController@edit']);
        Route::put('/{jobPostID}',['as' => 'jobPost.update', 'uses'=>'Recruitment\JobPostController@update']);
        Route::delete('/{jobPostID}/delete',['as'=>'jobPost.delete','uses'=>'Recruitment\JobPostController@destroy']);
    });

    Route::group(['prefix' => 'jobCandidate'], function () {
        Route::get('/',['as' => 'jobCandidate.index', 'uses'=>'Recruitment\JobCandidateController@index']);
        Route::get('applyCandidateList/{id}',['as'=>'jobCandidate.applyCandidateList','uses'=>'Recruitment\JobCandidateController@applyCandidateList']);
        Route::get('shortListedApplicant/{id}',['as'=>'jobCandidate.shortListedApplicant','uses'=>'Recruitment\JobCandidateController@shortListedApplicant']);
        Route::get('shortlist/{id}',['as'=>'applicant.shortlist','uses'=>'Recruitment\JobCandidateController@shortlist']);
        Route::get('reject/{id}',['as'=>'applicant.reject','uses'=>'Recruitment\JobCandidateController@reject']);
        Route::get('jobInterview/{id}',['as'=>'applicant.jobInterview','uses'=>'Recruitment\JobCandidateController@jobInterview']);
        Route::post('jobInterviewStore/{id}',['as' => 'applicant.jobInterviewStore', 'uses'=>'Recruitment\JobCandidateController@jobInterviewStore']);
        Route::get('rejectedApplicant/{id}',['as'=>'jobCandidate.rejectedApplicant','uses'=>'Recruitment\JobCandidateController@rejectedApplicant']);
        Route::get('jobInterviewList/{id}',['as'=>'jobCandidate.jobInterviewList','uses'=>'Recruitment\JobCandidateController@jobInterviewList']);
    });

});

