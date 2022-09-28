<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use Modules\Linker\Http\Controllers\LinkerController;

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

// Route::middleware('auth:api')->get('/linker', function (Request $request) {
//     return $request->user();
// });
    Route::middleware('jwt')->group(function () {

        Route::prefix('linker')->group(function () {
            
        Route::post('auth', 'LinkerController@login');
        // Route::get('verifToken', 'LinkerController@verifToken');

        Route::get('/', 'LinkerController@index');
        Route::get('/{id}', 'LinkerController@showByid');

        
        Route::post('/', 'LinkerController@createConta');
        Route::put('/{id}', 'LinkerController@updateConta');

        Route::put('requestTokenPayments/{id}', 'LinkerController@requestTokenPayments');
        Route::put('aprovarTokenPayments/{id}', 'LinkerController@aprovarTokenPayments');

        Route::put('requestTokenExtrato/{id}', 'LinkerController@requestTokenExtrato');
        Route::put('aprovarTokenExtrato/{id}', 'LinkerController@aprovarTokenExtrato');

        Route::post('payBarCode', 'LinkerController@payBarCode');
        Route::post('agendar', 'LinkerController@agendarPayments');
        Route::get('relatorio/clientes', 'LinkerController@relatorioClientesLinker');




        

        
        Route::post('/faturamento', 'LinkerController@pegar_faturamento');

        

        //requisirtar token conta 
        // Route::get('requestTokenPayments/{id}', 'LinkerController@requestTokenPayments');

        



    // Route::post('auth', [LinkerController::class,'login']);

        });
});