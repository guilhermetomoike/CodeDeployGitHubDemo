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
    Route::post('questionario/estatico', 'Modules\Questionario\Http\Controllers\QuestionarioController@estatico');
    Route::get('questionario/completo/{id}', 'Modules\Questionario\Http\Controllers\QuestionarioController@full');
    Route::get('questionario/respondeu/{id}/{costumer_id}', 'Modules\Questionario\Http\Controllers\QuestionarioController@respondeu');
    Route::apiResource('questionario', 'Modules\Questionario\Http\Controllers\QuestionarioController');
    Route::apiResource('questionario-pagina', 'Modules\Questionario\Http\Controllers\QuestionarioPaginaController');
    Route::apiResource('questionario-parte', 'Modules\Questionario\Http\Controllers\QuestionarioParteController');
    Route::apiResource('questionario-pergunta', 'Modules\Questionario\Http\Controllers\QuestionarioPerguntaController');
    Route::apiResource('questionario-pergunta-escolha', 'Modules\Questionario\Http\Controllers\QuestionarioPerguntaEscolhaController');
    Route::apiResource('questionario-resposta', 'Modules\Questionario\Http\Controllers\QuestionarioRespostaController');
});
