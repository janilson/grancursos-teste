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
Route::group(['middleware' => ['api']], function () {
    Route::get('/', 'ApiGranCursosController@apiAssuntos');

    Route::get('assunto', 'ApiGranCursosController@apiAssuntos');

    Route::get('banca', 'ApiGranCursosController@apiBancas');

    Route::get('orgao', 'ApiGranCursosController@apiOrgaos');
});
