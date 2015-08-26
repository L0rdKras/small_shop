<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

//Route::get('home', 'HomeController@index');

Route::get('/articulos', ['as'=>'articulos', 'uses' => 'ArticlesController@index']);

/******rutas descripciones*******/

Route::get('/articulos/descripciones', ['as'=>'descripciones', 'uses' => 'ArticlesController@add_descriptions']);

Route::post('/articulos/descripciones', ['as'=>'salva_descripcion', 'uses' => 'ArticlesController@save_description']);

Route::delete('/articulos/descripciones/borrar/{id}', ['as'=>'borra_descripcion', 'uses' => 'ArticlesController@delete_description']);

Route::get('/articulos/descripciones/editar/{id}', ['as'=>'editar_descripcion', 'uses' => 'ArticlesController@edit_descriptions']);

Route::patch('/articulos/descripciones/editar/{id}', ['as'=>'actualiza_descripcion', 'uses' => 'ArticlesController@update_descriptions']);

/*****************/

/************rutas articulos**************/

Route::get('/articulos/crear_articulos', ['as'=>'crear_articulos', 'uses' => 'ArticlesController@create_articles']);

Route::post('/articulos/guarda_articulo', ['as'=>'guarda_articulo', 'uses' => 'ArticlesController@save_articles']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
