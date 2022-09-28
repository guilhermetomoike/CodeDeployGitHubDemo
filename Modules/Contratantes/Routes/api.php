<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {
    Route::apiResource('contratantes', 'ContratantesController');
});