<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view( '/', 'pages.dashboard', [ 'title' => __( 'Dashboard' ) ] );

Route::view( '/settings', 'pages.settings', [ 'title' => __( 'Settings' ) ] );

Route::resource( 'projects', 'ProjectController' );

Route::resource( 'snippets', 'SnippetController' );

Route::get( 'category/{category}', 'CategoryController@index' );
Route::get( '{type}/category/{category}', 'CategoryController@type_index' );
