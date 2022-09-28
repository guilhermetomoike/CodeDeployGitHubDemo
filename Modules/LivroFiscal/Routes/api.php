<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\LivroFiscal\Http\Controllers\LivroFiscalController;

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
    Route::apiResource('livro-fiscal', LivroFiscalController::class);
});
