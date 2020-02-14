<?php

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


Route::resource('adesao', 'AdesaoController')
    ->only('store', 'show', 'index');

Route::resource('adesao', 'AdesaoController@adesao')
    ->middleware('auth:api')
    ->only('update');

Route::get('adesao/{adesao}/pdf', 'AdesaoPdfController@gerarPdf')
    ->middleware('api');

Route::resource('servidor', 'ServidorController')
    ->middleware('auth:api')
    ->middleware('check.profile:I')
    ->only( 'index');

Route::group(['middleware' => ['auth:api', 'api']], function () {
    Route::apiResource('adesao', 'AdesaoController')
        ->only('update');
});