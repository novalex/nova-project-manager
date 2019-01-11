<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminMenuController extends AdminController {

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
	 * Resource's view.
	 *
	 * @var string
	 */
	public $view = 'pages.admin.menus';

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'admin/menus';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$route = Route::current();
		\View::share( 'action', $route ? $route->getActionMethod() : 'index' );

		\View::share( 'url', $this->url );

		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view(
			$this->view,
			array(
				'title' => sprintf( __( 'Manage %s' ), $this->strings['plural'] ),
				'menus' => Menu::all(),
			)
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view(
			$this->view,
			array(
				'title'        => sprintf( __( 'New %s' ), $this->strings['singular'] ),
				'menu_options' => $this->getMenuOptions(),
			)
		);
	}

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
	 * Display a menu.
	 *
	 * @param  \App\Menu $menu Model.
	 * @return \Illuminate\Http\Response
	 */
	public function show( Menu $menu ) {
		return view(
			$this->view,
			array(
				'title' => $menu->name,
				'menu'  => $menu,
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Menu $menu Model.
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Menu $menu ) {
		return view(
			$this->view,
			array(
				'title'        => sprintf( __( 'Edit %s' ), $menu->name ),
				'menu'         => $menu,
				'menu_options' => $this->getMenuOptions( $menu->id ),
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
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Menu $menu Model.
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Menu $menu ) {
		$title = $menu->name;

		$menu->destroy( $menu->id );

		return redirect( $this->url )->with(
			[
				'status'  => 'success',
				'message' => sprintf( __( 'Deleted %s' ), $title ),
			]
		);
	}

	/**
	 * Get array of options for menu items.
	 *
	 * @param int $menu_id ID of the current menu item.
	 * @return array
	 */
	public function getMenuOptions( int $menu_id = 0 ) {
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
			'parent' => array(
				'type'    => 'select',
				'label'   => __( 'Parent' ),
				'choices' => $menu_parents,
			)
		);
	}
}
