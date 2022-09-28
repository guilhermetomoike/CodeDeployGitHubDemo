<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as Route;

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
Route::post('/tax-simulator/index', 'TaxSimulatorController@simulator');

Route::post('/simulator/calculate', 'TaxSimulatorController@index');
Route::post('/simulator/export', 'TaxSimulatorController@exportSimulacao');

Route::middleware('auth:api')->get('/taxsimulator', function (Request $request) {
    return $request->user();
});
