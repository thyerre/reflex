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

Route::post('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');
Route::post('auth/refresh', 'AuthController@refresh');

Route::group(['middleware' => 'jwt.auth'], function(){  
    Route::resource('config', 'ConfiguracaoDatabaseController');
    Route::resource('menu', 'MenuController');
    Route::resource('configuracao', 'ConfiguracaoController');
    Route::get('configuracao/info/{id}', 'ConfiguracaoController@getInformacoesAtualizacao');
    Route::get('all/tables', 'DataWarehouseController@getTables');
    Route::resource('data-warehouse', 'DataWarehouseController');
    Route::get('fk/table/{table}', 'DataWarehouseController@getFKByTable');
    
    Route::get('columns/table/{table}', 'DataWarehouseController@getColumnsByTable');
    Route::get('me', 'AuthController@me');
});