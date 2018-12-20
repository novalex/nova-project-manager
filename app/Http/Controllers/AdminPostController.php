<?php

namespace App\Http\Controllers;

use App\PostType;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminPostController extends PostController {

	/**
	 * Constructor.
	 */
	public function __construct() {
		new AdminController();

		parent::__construct();

		$this->url = 'admin/posts';

		$this->views['index'] = 'pages.admin.posts';

		\View::share( 'post_types', PostType::all() );
	}

}
