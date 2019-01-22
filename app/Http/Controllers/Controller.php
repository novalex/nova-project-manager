<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Constructor.
	 */
	public function __construct() {
	}

	/**
	 * Display index page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		\View::share( 'has_search', true );

		$stats = array(
			array(
				'title'  => __( 'Users' ),
				'icon'   => 'fas fa-users',
				'number' => \App\User::count(),
				'url'    => url( 'admin/users' ),
			),
		);

		$post_type_icons = array(
			'project' => 'fas fa-project-diagram',
			'snippet' => 'far fa-file-alt',
		);

		foreach ( \DB::table( 'post_types' )->get() as $post_type ) {
			$stats[] = array(
				'title'  => str_plural( $post_type->name ),
				'icon'   => isset( $post_type_icons[ $post_type->slug ] ) ? $post_type_icons[ $post_type->slug ] : 'fas fa-chart-bar',
				'number' => \DB::table( 'posts' )->where( 'post_type', $post_type->id )->count(),
				'url'    => url( str_plural( $post_type->slug ) ),
			);
		}

		\View::share( 'stats', $stats );

		return view( 'pages.dashboard', array(
			'title' => __( 'Dashboard' ),
		) );
	}
}
