<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| Here is where you can register webhook routes for your application receive
| notifications from another application of integration. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "webhook" middleware group. Now create something great!
|
*/

Route::prefix('twilio')->group(function () {
    Route::post('incoming', 'WhatsappMessageController@incoming');
    Route::post('status', 'WhatsappMessageController@receiveStatus');
});

Route::post('nfse', 'NfseController@webhook');

Route::post('clicksign', 'ClicksignWebhookController');

Route::post('ploomes', 'EmpresaPreCadastroController@webhookPloomes');

//Route::post('invites', 'InviteController@webhook');
