<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {
    Route::prefix('/evaluation')->group(function () {
        Route::post('/' , 'EvaluationController@store');
        Route::post('/{id}' , 'EvaluationController@update');
        Route::get('/{slug}/slug', 'EvaluationController@index');
    });

    Route::prefix('/evaluate')->group(function () {
        Route::post('/', 'EvaluationEntityController@store');
        Route::get('/{evaluation_id}/{evaluable_type}/{evaluable_id}', 'EvaluationEntityController@index');
    });
});
