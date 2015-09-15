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

Route::delete('/articulos/borrar/articulo/{id}', ['as'=>'borra_articulo', 'uses' => 'ArticlesController@delete_article']);

Route::get('/articulos/editar/articulo/{id}', ['as'=>'editar_articulo', 'uses' => 'ArticlesController@edit_article']);

Route::patch('/articulos/editar/articulo/{id}', ['as'=>'actualiza_articulo', 'uses' => 'ArticlesController@update_article']);

Route::get('/articulos/compras/{id}', ['as'=>'compras_articulo', 'uses' => 'ArticlesController@article_purchases']);

Route::get('/articulos/ventas/{id}', ['as'=>'ventas_articulo', 'uses' => 'ArticlesController@article_sales']);

/******Codigo de barra********/

Route::get('/articulos/codigo/de/barra/articulo/{id}', ['as'=>'codigo_de_barra', 'uses' => 'ArticlesController@barcode_article']);

Route::post('/articulos/guarda/codigo/de/barra', ['as'=>'guarda_codigo', 'uses' => 'ArticlesController@save_barcode']);

Route::delete('/articulos/borra/codigo/de/barra/{id}', ['as'=>'borra_codigo', 'uses' => 'ArticlesController@delete_barcode']);

/*************COMPRAS***************/

Route::get('/compras', ['as'=>'compras', 'uses' => 'PurchasesController@index']);

/*****************proveedores************************/

Route::get('/compras/proveedores', ['as'=>'proveedores', 'uses' => 'PurchasesController@suppliers']);

Route::post('/compras/guarda/proveedor', ['as'=>'salva_proveedor', 'uses' => 'PurchasesController@save_supplier']);

Route::get('/compras/editar/proveedor/{id}', ['as'=>'editar_proveedor', 'uses' => 'PurchasesController@edit_supplier']);

Route::patch('/compras/editar/proveedor/{id}', ['as'=>'actualiza_proveedor', 'uses' => 'PurchasesController@update_supplier']);

/**************ingreso de compras**********************/

Route::get('/compras/registro', ['as'=>'registro_compras', 'uses' => 'PurchasesController@purchase_register']);

Route::get('/compras/registro/suppliers_list', ['as'=>'show_list_suppliers', 'uses' => 'PurchasesController@suppliers_list']);

Route::get('/compras/registro/supplier/data/{id}', ['as'=>'load_supplier_data', 'uses' => 'PurchasesController@supplier_data']);

Route::get('/compras/registro/load/code/{code}', ['as'=>'load_code', 'uses' => 'PurchasesController@load_code']);

Route::get('/compras/registro/insert/article/{code}/{id}', ['as'=>'insert_article', 'uses' => 'PurchasesController@load_code']);

Route::post('/compras/registro/save/purchase/{json}/{id}/{document}/{number}', ['as'=>'save_purchase', 'uses' => 'PurchasesController@save_purchase']);

Route::get('/compras/historial',['as'=>'historial_compras','uses'=>'PurchasesController@purchases_list']);

Route::get('/compras/historial/info/compra/{id}',['as'=>'info_compra','uses'=>'PurchasesController@purchase_info']);

/**********************Ventas****************************/

Route::get('/ventas', ['as'=>'ventas', 'uses' => 'SalesController@index']);

Route::get('/ventas/emitir', ['as'=>'registro_ventas', 'uses' => 'SalesController@sell']);

Route::post('/ventas/guardar/{json}/{total}', ['as'=>'save_sale', 'uses' => 'SalesController@save_sale']);

Route::get('/ventas/historial',['as'=>'historial_ventas','uses'=>'SalesController@sales_list']);

Route::get('/ventas/historial/info/venta/{id}',['as'=>'info_venta','uses'=>'SalesController@sale_info']);

/***************************Clientes*********************************************/

Route::get('/clientes/registro',['as'=>'registro_cliente','uses'=>'ClientController@register_form']);

Route::post('/clientes/registro',['as'=>'guardar_cliente','uses'=>'ClientController@save_client']);

Route::get('/clientes/editar/{id}',['as'=>'editar_cliente','uses'=>'ClientController@edit_client']);

Route::patch('/clientes/editar/{id}',['as'=>'actualiza_cliente','uses'=>'ClientController@update_client']);

/***********************Impresiones******************************/

Route::get('/impresion/venta/{id}',['as'=>'imp_venta','uses'=>'PdfController@sale']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
