<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Category;

class AdminController extends Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
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
			array(
				'url'     => 'admin/posts',
				'name'    => __( 'Posts' ),
				'class'   => 'half' . ( \Request::is( [ 'admin/posts', 'admin/posts/*' ] ) ? ' active' : '' ),
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
		return view( 'pages.admin.index', array(
			'title' => __( 'Dashboard' ),
		) );
	}

}
