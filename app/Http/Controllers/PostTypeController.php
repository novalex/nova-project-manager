<?php

namespace App\Http\Controllers;

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

		parent::__construct();
	}

}
