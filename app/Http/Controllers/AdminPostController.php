<?php

namespace App\Http\Controllers;

use App\PostType;

class AdminPostController extends PostController {

	/**
	 * Constructor.
	 */
	public function __construct() {
		new AdminController();

		$this->url = 'admin/posts';

		$this->views['index'] = 'pages.admin.posts';

		$post_types = PostType::all();
		if ( empty( $post_types ) ) {
			$post_types = array();
		}
		\View::share( 'post_types', $post_types );

		parent::__construct();
	}

}
