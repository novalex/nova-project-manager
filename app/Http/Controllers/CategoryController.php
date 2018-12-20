<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoryController extends Controller {

	/**
	 * Display a category folder.
	 *
	 * @param  string $category
	 * @return \Illuminate\Http\Response
	 */
	public function index( Category $category ) {
		$title = 'Manage ' . $category->name . ' caca';

		$posts = $category->posts( $category->id );

		return view( 'pages.snippets.category', compact( 'title', 'category', 'posts' ) );
	}

	/**
	 * Display a category folder by type.
	 *
	 * @param string $type     The category type.
	 * @param string $category The category.
	 * @return \Illuminate\Http\Response
	 */
	public function type_index( $type, Category $category ) {
		$title = sprintf( __( 'Manage %s' ), "$category->name $type" );

		if ( $category->type !== $type ) {
			$category = Category::where([ [ 'slug', $category->slug ], [ 'post_type', str_singular($type) ] ])->first();
		}

		$posts = $category->$type( $category->id );

		return view( 'pages.posts.category', compact( 'title', 'category', 'posts' ) );
	}
}
