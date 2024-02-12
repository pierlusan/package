<?php

use Illuminate\Support\Facades\Route;
use LP\surveys\Controllers\SurveysController;

Route::get('surveys/create',[SurveysController::class,'create']);
Route::post('surveys/create',[SurveysController::class,'store']);
Route::get('surveys/edit/{survey}',[SurveysController::class,'edit']);
Route::get('surveys/edit/add_module/{survey}',[SurveysController::class, 'createModule']);
Route::post('surveys/edit/add_module/{survey}',[SurveysController::class, 'storeModule']);
Route::get('surveys/edit/add_question/{survey}/{module}',[SurveysController::class , 'createQuestion']);
Route::post('surveys/edit/add_question/{survey}/{module}',[SurveysController::class , 'storeQuestion']);
Route::get('surveys/{survey}/{module?}',[SurveysController::class,'showSurvey']);
Route::post('surveys/saveResponse',[SurveysController::class,'saveResponse'])->name('surveys.saveResponse');
