<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt')->group(function () {
    Route::apiResource('plans/subscription', 'PlanSubscriptionController')
        ->only('index', 'store');
    Route::delete('plans/subscription/{payer_type}/{payer_id}', 'PlanSubscriptionController@destroy')
        ->where(['payer_type' => '^(cliente|empresa)$', 'payer_id' => '[0-9]+']);

    Route::apiResources([
        'plans/service-table' => 'ServiceTableController',
        'plans' => 'PlansController'
    ]);
});
