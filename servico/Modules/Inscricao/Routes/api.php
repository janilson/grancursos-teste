<?php

//use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api', 'api']], function () {

    Route::apiResource('grupo', 'GrupoController')
        ->only('index');

    Route::apiResource('adesao.grupo', 'InscricaoController')
        ->only('update', 'store');

    Route::apiResource('adesao.grupo.pre-requisito', 'PreRequisitoController')
        ->only('store');

    Route::apiResource('adesao.historico', 'HistoricoController')
        ->only('index');

    Route::apiResource('adesao.envio', 'InscricaoEnvioController')
        ->middleware('check.profile:E')
        ->only('store');

    Route::apiResource('bloqueio', 'BloqueioController');

    Route::apiResource('arquivo', 'ArquivoController')
        ->only('show');

    Route::get('inscricao/{co_adesao}/pdf', 'InscricaoController@getPdf');

    Route::get('inscricao/{co_adesao}/resumo', 'InscricaoController@resumo');


});