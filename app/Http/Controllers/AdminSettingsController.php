<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingsController extends AdminController {

	/**
	 * Display settings page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'pages.admin.settings', array(
			'title'  => __( 'Manage Settings' ),
			'fields' => $this->getSettingsFields(),
		) );
	}

	/**
	 * Return array of settings fields.
	 *
	 * @return array
	 */
	public function getSettingsFields() {
		return array(
			'ui_show_logo' => array(
				'type'  => 'checkbox',
				'label' => __( 'Show Logo' ),
				'desc'  => __( 'Whether to show the logo image in the main menu.' ),
			),
			'ui_show_dashboard_menu' => array(
				'type'  => 'checkbox',
				'label' => __( 'Show "Dashboard" Menu Item' ),
			),
		);
	}
}
