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

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AutenticacaoController@login');
    Route::post('recuperar-senha', 'AutenticacaoController@recuperarSenha');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AutenticacaoController@logout')->name('logout');
        Route::post('refresh', 'AutenticacaoController@refresh');
        Route::get('me', 'AutenticacaoController@me');
    });
});