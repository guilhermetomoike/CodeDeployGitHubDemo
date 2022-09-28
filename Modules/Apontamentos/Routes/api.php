<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {
    Route::apiResource('apontamentos', 'ApontamentosController')->except(['show']);
});