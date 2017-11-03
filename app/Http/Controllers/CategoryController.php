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
		$posts = $category->posts( $category->id );
		return view( 'pages.snippets.category', compact( 'category', 'posts' ) );
	}

	/**
	 * Display a category folder by type.
	 *
	 * @param  string $category
	 * @return \Illuminate\Http\Response
	 */
	public function type_index( $type, Category $category ) {
		if ( $category->type !== $type ) {
			$category = Category::where([ [ 'slug', $category->slug ], [ 'type', str_singular($type) ] ])->first();
		}
		$posts = $category->$type( $category->id );
		return view( 'pages.' . $type . '.category', compact( 'category', 'posts' ) );
	}
}
