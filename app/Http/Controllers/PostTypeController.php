<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\PostType;

use Illuminate\Support\Facades\Route;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PostTypeController extends PostController {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$route     = Route::current();
		$route_url = $route ? $route->uri : 'posts';
		$type      = str_singular( explode( '/', $route_url )[0] );
		$post_type = PostType::where( 'slug', $type )->first();

		$this->url       = $post_type['url'];
		$this->post_type = $post_type;
		$this->strings   = array(
			'singular' => $post_type['name'],
			'plural'   => str_plural( $post_type['name'] )
		);

		\View::share( 'sec_menu_items', get_nav_menu_items( 'categories', array(
			'post_type' => $post_type,
		) ) );

		parent::__construct();
	}

	/**
	 * Display a category folder.
	 *
	 * @param string $category_slug The category slug.
	 * @return \Illuminate\Http\Response
	 */
	public function category_index( $category_slug ) {
		$category = Category::where( array(
			array( 'slug', $category_slug ),
			array( 'post_type', $this->post_type->id ),
		) )->first();

		$title = sprintf( __( 'Manage %1$s %2$s' ), $category->name, str_plural( $this->post_type->name ) );

		$posts = Post::where( 'category', $category->id )->get();

		return view( 'pages.posts.category', compact( 'title', 'category', 'posts' ) );
	}

}
