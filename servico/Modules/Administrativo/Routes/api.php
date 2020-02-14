<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['auth:api', 'api', 'check.profile:I']], function () {

    Route::apiResource('classificacao', 'ClassificacaoController')
        ->only('index', 'store');

    Route::apiResource('classificacao/adesao', 'ClassificacaoController')
        ->only('show');
});