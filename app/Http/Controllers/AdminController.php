<?php

namespace App\Http\Controllers;

class AdminController extends Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		\View::share( 'sec_menu_items', array(
			array(
				'url'     => 'admin',
				'name'    => __( 'Dashboard' ),
				'class'   => 'half' . ( \Request::is( [ 'admin', 'admin/' ] ) ? ' active' : '' ),
			),
			array(
				'url'     => 'admin/settings',
				'name'    => __( 'Settings' ),
				'class'   => 'half' . ( \Request::is( [ 'admin/settings', 'admin/settings/*' ] ) ? ' active' : '' ),
			),
			array(
				'url'     => 'admin/menus',
				'name'    => __( 'Menus' ),
				'class'   => 'half' . ( \Request::is( [ 'admin/menus', 'admin/menus/*' ] ) ? ' active' : '' ),
			),
			// array(
			// 	'url'     => 'admin/posts',
			// 	'name'    => __( 'Posts' ),
			// 	'class'   => 'half' . ( \Request::is( [ 'admin/posts', 'admin/posts/*' ] ) ? ' active' : '' ),
			// ),
			array(
				'url'     => 'admin/post-types',
				'name'    => __( 'Post Types' ),
				'class'   => 'half' . ( \Request::is( [ 'admin/post-types', 'admin/post-types/*' ] ) ? ' active' : '' ),
			),
			array(
				'url'     => 'admin/users',
				'name'    => __( 'Users' ),
				'class'   => 'half' . ( \Request::is( [ 'admin/users', 'admin/users/*' ] ) ? ' active' : '' ),
			),
		) );
	}

	/**
	 * Display admin index page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
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

		return view( 'pages.admin.index', array(
			'title' => __( 'Dashboard' ),
		) );
	}

}
