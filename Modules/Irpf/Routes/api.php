<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Middleware\InvoiceWebhook;

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

Route::middleware('jwt')->prefix('/irpf')->group(function () {

    Route::get('questionario', 'IrpfQuestionController@getQuestionarioForCustomer');
    Route::post('questionario', 'IrpfQuestionController@responder');

    Route::get('pendencias', 'IrpfQuestionController@getPendenciasForCustomer');
    Route::post('pendencias', 'IrpfQuestionController@savePendencia');

    Route::apiResource('questionario/manage', 'IrpfQuestionController');
    Route::options('questionario/manage/{ano}', 'IrpfQuestionController@show2');

    Route::delete('questionario/pendencia/input/{input_id}', 'IrpfQuestionController@deletePendenciaInput');


    Route::get('{cliente_id}', 'IrpfController@getDeclaracao');
    Route::patch('{cliente_id}', 'IrpfController@finalizaIrpf');
    Route::put('exclusao/{irpf}', 'IrpfController@exclusaoDeclaracao');



    Route::get('{cliente_id}/questionario', 'IrpfController@getQuestoes');
    Route::post('{cliente_id}/questionario', 'IrpfController@storeRespostaQuestionario');

    //desabilitando envio de 
    Route::post('{cliente_id}/change-to-aceito', 'IrpfController@changeIrpfToAceito');
    Route::post('{cliente_id}/change-to-cancelou', 'IrpfController@changeIrpfToCancelado');

    Route::post('{cliente_id}/change-to-isento', 'IrpfController@changeIrpfToIsento');

    Route::get('{cliente_id}/docie', 'IrpfController@downloadDocie');
 



    Route::get('{cliente_id}/pendencia', 'IrpfController@getPendencia');
    Route::post('{cliente_id}/pendencia/{pendencia_id}/input', 'IrpfController@storeItem');

    Route::get(null, 'IrpfController@getClientesList');


});

Route::middleware('jwt')->group(function () {
Route::get('relatorio-irpf', 'IrpfController@relatorioirpf');
Route::get('relatorio-resumido-irpf', 'IrpfController@relatorioirpfResumo');

});
Route::middleware(InvoiceWebhook::class)
    ->post('/webhook/irpf/charge-notification', 'WebhookChargeController');
