<?php

namespace App\Http\Controllers;

use App\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminPostTypeController extends AdminController {

	/**
	 * Array of strings describing the resource.
	 *
	 * @var array
	 */
	public $strings = array(
		'singular' => 'post type',
		'plural'   => 'post types',
	);

	/**
	 * Resource's view.
	 *
	 * @var string
	 */
	public $view = 'pages.admin.post-types';

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'admin/post-types';

	/**
	 * Constructor.
	 */
	public function __construct() {
		\View::share( 'url', $this->url );

		$route = Route::current();
		\View::share( 'action', $route ? $route->getActionMethod() : 'index' );

		$post_types = PostType::all();
		if ( empty( $post_types ) ) {
			$post_types = array();
		}
		\View::share( 'post_types', $post_types );

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
				'title'      => sprintf( __( 'Manage %s' ), $this->strings['plural'] ),
				'post_types' => PostType::all(),
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
				'title' => sprintf( __( 'New %s' ), $this->strings['singular'] ),
			)
		);
	}

	/**
	 * Store a newly created resource.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate(
			array(
				'name' => 'required|unique:post_types|max:255',
				'slug' => 'unique:post_types',
			)
		);

		$slug = empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug );

		$post_type = PostType::create(
			array(
				'name' => $request->name,
				'slug' => $slug,
			)
		);

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Created %s' ), $post_type->name ),
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\PostType $post_type Model.
	 * @return \Illuminate\Http\Response
	 */
	public function edit( PostType $post_type ) {
		return view(
			$this->view,
			array(
				'post_type' => $post_type,
				'title'     => sprintf( __( 'Edit %s' ), $post_type->name ),
			)
		);
	}

	/**
	 * Update the specified resource.
	 *
	 * @param  \Illuminate\Http\Request $request   Request object.
	 * @param  \App\PostType            $post_type Model.
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, PostType $post_type ) {
		$request->validate(
			array(
				'name' => sprintf( 'required|unique:post_types,name,%d|max:255', $post_type->id ),
				'slug' => sprintf( 'unique:post_types,slug,%d', $post_type->id ),
			)
		);

		$slug = empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug );

		$post_type->update(
			array(
				'name' => $request->name,
				'slug' => $slug,
			)
		);

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Updated %s' ), $post_type->name ),
			)
		);
	}

	/**
	 * Remove the specified resource.
	 *
	 * @param  \App\PostType $post_type Model.
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( PostType $post_type ) {
		$title = $post_type->name;

		$post_type->destroy( $post_type->id );

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Deleted %s' ), $title ),
			)
		);
	}
}
