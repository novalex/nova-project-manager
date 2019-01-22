<?php

use App\PostType;

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

// Index page.
Route::get( '/', 'Controller@index' );

// Define settings routes.
Route::prefix( 'admin' )->group( function() {
	Route::get( '/', 'AdminController@index' );
	Route::get( 'settings', 'AdminSettingsController@index' );
	Route::resource( 'menus', 'AdminMenuController' );
	Route::resource( 'posts', 'AdminPostController' );
	Route::resource( 'post-types', 'AdminPostTypeController' );
	Route::resource( 'users', 'AdminUserController' );
} );

// Create post type routes.
if ( Schema::hasTable('post_types') ) {
	$post_types = PostType::all();

	foreach ( $post_types as $post_type ) {
		// Create resource routes for post type.
		Route::resource( $post_type['url'], 'PostTypeController', array(
			'parameters' => array(
				$post_type['url'] => 'post',
			)
		) );

		// Create category routes for post type.
		Route::get( "{$post_type['url']}/category/{category}", 'PostTypeController@category_index' );
	}
}

// Search.
Route::get( '/search', 'SearchController@index' );
