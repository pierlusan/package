<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use LP\surveys\Controllers\SurveysController;


Route::middleware(['web'])->group(function () {
    Auth::routes();
    Route::get('surveys/create',[SurveysController::class,'create'])->name('surveys.create');
    Route::post('surveys/create',[SurveysController::class,'store'])->name('surveys.store');
    Route::get('surveys/edit/{survey}',[SurveysController::class,'edit'])->name('surveys.edit');
    Route::get('surveys/edit/add_module/{survey}',[SurveysController::class, 'createModule'])->name('surveys.createModule');
    Route::post('surveys/edit/add_module/{survey}',[SurveysController::class, 'storeModule'])->name('surveys.storeModule');
    Route::get('surveys/edit/add_question/{survey}/{module}',[SurveysController::class , 'createQuestion'])->name('surveys.createQuestion');
    Route::post('surveys/edit/add_question/{survey}/{module}',[SurveysController::class , 'storeQuestion'])->name('surveys.storeQuestion');

    Route::get('surveys/{survey}/{module?}',[SurveysController::class,'showSurvey'])->name('surveys.showSurvey');
    Route::post('surveys/saveResponse/{survey}/{module}',[SurveysController::class,'saveResponse'])->name('surveys.saveResponse');

    Route::get('surveys/showResponse/{survey}/{user}',[SurveysController::class,'showResponses'])->name('surveys.showResponses');
});



