<?php

namespace App\Http\Controllers;

use App\Menu;

class AdminMenuController extends AdminCrudController {

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'admin/menus';

	/**
	 * Array of strings describing the resource.
	 *
	 * @var array
	 */
	public $strings = array(
		'singular' => 'menu',
		'plural'   => 'menus',
	);

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate(
			array(
				'name'    => 'required|unique:menus|max:255',
				'url'     => 'required|unique:menus',
				'options' => 'nullable|array',
				'parent'  => 'nullable|integer',
			)
		);

		$menu = Menu::create(
			array(
				'name'    => $request->name,
				'url'     => $request->url,
				'options' => $request->options,
				'parent'  => $request->parent,
			)
		);

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Created %s' ), $menu->name ),
			)
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @param  \App\Menu                $menu    Model.
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Menu $menu ) {
		$request->validate(
			array(
				'name'    => "required|unique:menus,name,{$menu->id}|max:255",
				'url'     => "required|unique:menus,url,{$menu->id}",
				'options' => 'nullable|array',
				'parent'  => 'nullable|integer',
			)
		);

		$menu->update(
			array(
				'name'    => $request->name,
				'url'     => $request->url,
				'options' => $request->options,
				'parent'  => $request->parent,
			)
		);

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Updated %s' ), $menu->name ),
			)
		);
	}

	/**
	 * Get the items to display.
	 *
	 * @return mixed
	 */
	public function getItems() {
		return Menu::all();
	}

	/**
	 * Get a single item by ID.
	 *
	 * @param int $id The ID of the item to fetch.
	 * @return mixed
	 */
	public function getItem( int $id ) {
		return Menu::where( 'id', $id )->first();
	}

	/**
	 * Get array of fields for create and edit views.
	 *
	 * @param int $menu_id ID of the current menu item.
	 * @return array
	 */
	public function getFields( int $menu_id = 0 ) {
		$menu_parents = array_merge(
			array(
				array(
					'value' => '',
					'label' => __( 'None' ),
				),
			),
			Menu::all()->whereNotIn( 'id', $menu_id )->map( function( $item ) {
				return array(
					'value' => $item->id,
					'label' => $item->name,
				);
			} )->toArray()
		);

		return array(
			'name'  => array(
				'type'  => 'text',
				'label' => __( 'Name' ),
			),
			'url'   => array(
				'type'   => 'text',
				'label'  => __( 'URL' ),
				'prefix' => url( '/' ),
			),
			'class' => array(
				'type'  => 'text',
				'label' => __( 'CSS Classes' ),
			),
			'icon'  => array(
				'type'  => 'text',
				'label' => __( 'Icon' ),
			),
			'image' => array(
				'type'  => 'text',
				'label' => __( 'Image' ),
			),
			// 'parent' => array(
			// 	'type'    => 'select',
			// 	'label'   => __( 'Parent' ),
			// 	'choices' => $menu_parents,
			// ),
		);
	}
}
