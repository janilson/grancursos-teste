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

Route::group(['middleware' => 'api'], function () {
    Route::get('uf', 'CoorporativoController@obterUnidadesFederativas');

    Route::get('uf/{uf}/municipio', 'CoorporativoController@obterMunicipiosDaUnidadeFederativa');

    Route::get('municipio/{co_ibge}/prefeito-vigente/', 'CoorporativoController@obterPrefeitoPorIbge');
});


