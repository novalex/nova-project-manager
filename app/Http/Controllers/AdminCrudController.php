<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class AdminCrudController extends AdminController {

	/**
	 * Resource's view.
	 *
	 * @var string
	 */
	public $view = 'pages.admin.crud';

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Array of strings describing the resource.
	 *
	 * @var array
	 */
	public $strings;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$route = Route::current();
		\View::share( 'action', $route ? $route->getActionMethod() : 'index' );

		\View::share( 'url', $this->url );

		\View::share( 'strings', $this->strings );

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
				'title' => sprintf( __( 'Manage %s' ), ucwords( $this->strings['plural'] ) ),
				'items' => $this->getItems(),
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
				'title'  => sprintf( __( 'New %s' ), $this->strings['singular'] ),
				'fields' => $this->getFields(),
			)
		);
	}

	/**
	 * Display a single item.
	 *
	 * @param int $id Model ID.
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		$item = $this->getItem( $id );

		return view(
			$this->view,
			array(
				'title' => $item->name,
				'item'  => $item,
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id Model ID.
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$item = $this->getItem( $id );

		return view(
			$this->view,
			array(
				'title'  => sprintf( __( 'Edit %s' ), $item->name ),
				'item'   => $item,
				'fields' => $this->getFields(),
			)
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id Model ID.
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$item = $this->getItem( $id );

		$title = $item->name;

		$item->destroy( $item->id );

		return redirect( $this->url )->with(
			[
				'status'  => 'success',
				'message' => sprintf( __( 'Deleted %s' ), $title ),
			]
		);
	}
}
