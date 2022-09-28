<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {
    Route::prefix('activity')->group(
        function () {
            Route::get('recurrence', 'ActivityScheduleController@recurrence');
            Route::get('status', 'ActivityScheduleController@status');
            Route::get('regimes', 'ActivityScheduleController@regimes');
            Route::get('wallters', 'ActivityScheduleController@wallters');

            Route::apiResource('schedule', 'ActivityScheduleController');
            Route::post('schedule/execute/{id}', 'ActivityScheduleController@executeActivitySchedule');
        }
    );
  

    // Route::prefix('atividades')->group(
    //     function () {
    //         Route::get('/', 'AtividadesController@index');
    //     }

    // );

    Route::apiResource("activity", 'ActivityController')->except(['store']);
    Route::apiResource("atividades", 'AtividadesController');
    Route::apiResource("etapas", 'EtapasController');
    

    Route::prefix('etapas_empresas')->group(
        function () {
 
            Route::post('/listagem', 'EtapasEmpresasController@listagem');
            Route::get('/{id}', 'EtapasEmpresasController@show');

            Route::post('/', 'EtapasEmpresasController@store');
            Route::put('/{id}', 'EtapasEmpresasController@update');

            Route::post('/comentar', 'EtapasEmpresasController@comentar_etapa_empresa');
            Route::get('/comentarios/{etapas_empresas_id}', 'EtapasEmpresasController@comentarios_etapa_empresa');


            
        }
    );

});
