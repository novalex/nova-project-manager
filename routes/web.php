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

// Define settings routes.
Route::prefix( 'admin' )->group( function() {
	Route::get( '/', 'AdminController@index' );
	Route::get( 'settings', 'AdminSettingsController@index' );
	Route::resource( 'menus', 'AdminMenuController' );
	Route::resource( 'posts', 'AdminPostController' );
	Route::resource( 'post-types', 'AdminPostTypeController' );
	Route::resource( 'users', 'AdminUserController' );
} );

Route::view( '/', 'pages.dashboard', array( 'title' => __( 'Dashboard' ) ) );

// Create post type routes.
$post_types = PostType::all();
foreach ( $post_types as $post_type ) {
	Route::resource( $post_type['url'], 'PostTypeController', array(
		'parameters' => array(
			$post_type['url'] => 'post',
		)
	) );
}

// Route::get( 'category/{category}', 'CategoryController@index' );
// Route::get( '{type}/category/{category}', 'CategoryController@type_index' );
