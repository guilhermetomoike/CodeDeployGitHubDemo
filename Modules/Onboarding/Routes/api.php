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
    // Onboarding
    Route::get('/onboardings', 'OnboardingController@index')->name('onboarding.index');
    Route::post('/onboardings', 'OnboardingController@store')->name('onboarding.store');
    Route::put('/onboardings/{onboarding}', 'OnboardingController@update')->name('onboarding.update');
    Route::delete('/onboardings/{onboarding}', 'OnboardingController@destroy')->name('onboarding.destroy');
    // Onboarding Item
    Route::get('/onboardings/{onboarding}/items', 'OnboardingItemController@index')->name('onboarding-item.index');
    Route::post('/onboardings/{onboarding}/items', 'OnboardingItemController@store')->name('onboarding-item.store');
    Route::put('/onboardings/items/{onboarding_item}', 'OnboardingItemController@update')->name('onboarding-item.update');
    Route::delete('/onboardings/items/{onboarding_item}', 'OnboardingItemController@destroy')->name('onboarding-item.destroy');
    // Empresa Pos Cadastro Onboarding
    Route::get('/empresas/{empresa}/poscadastro/onboardings', 'EmpresaPosCadastroOnboardingController@index')->name('empresa-pos-cadastro-onboarding.index');
    Route::post('/empresas/{empresa}/poscadastro/onboardings', 'EmpresaPosCadastroOnboardingController@store')->name('empresa-pos-cadastro-onboarding.store');
    Route::put('/empresas/poscadastro/onboardings/{empresa_pos_cadastro_onboarding}', 'EmpresaPosCadastroOnboardingController@update')->name('empresa-pos-cadastro-onboarding.update');
    Route::delete('/empresas/{empresa}/poscadastro/onboardings', 'EmpresaPosCadastroOnboardingController@destroy')->name('empresa-pos-cadastro-onboarding.destroy');
});
