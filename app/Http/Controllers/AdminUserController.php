<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Route;

class AdminUserController extends AdminController {

	/**
	 * Array of strings describing the resource.
	 *
	 * @var array
	 */
	public $strings = array(
		'singular' => 'user',
		'plural'   => 'users',
	);

	/**
	 * Resource's view.
	 *
	 * @var string
	 */
	public $view = 'pages.admin.users';

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'admin/users';

	/**
	 * Constructor.
	 */
	public function __construct() {
		\View::share( 'url', $this->url );
		\View::share( 'action', Route::current() );

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
				'users' => User::all(),
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate(
			array(
				'name'    => 'required|unique:users|max:255',
				'url'     => 'required|unique:users',
				'options' => 'nullable|array',
				'parent'  => 'nullable|integer',
			)
		);

		$user = User::create(
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
				'message' => sprintf( __( 'Created %s' ), $user->name ),
			)
		);
	}

	/**
	 * Display a user.
	 *
	 * @param  \App\User $user Model.
	 * @return \Illuminate\Http\Response
	 */
	public function show( User $user ) {
		return view(
			$this->view,
			array(
				'title' => $user->name,
				'user'  => $user,
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User $user Model.
	 * @return \Illuminate\Http\Response
	 */
	public function edit( User $user ) {
		return view(
			$this->view,
			array(
				'title' => __( 'Edit %s', $user->name ),
				'user'  => $user,
			)
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @param  \App\User                $user    Model.
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, User $user ) {
		$request->validate(
			array(
				'name'    => 'required|unique:users|max:255',
				'url'     => 'required|unique:users',
				'options' => 'nullable|array',
				'parent'  => 'nullable|integer',
			)
		);

		$user->update(
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
				'message' => sprintf( __( 'Updated %s' ), $user->name ),
			)
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User $user Model.
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( User $user ) {
		$title = $user->name;

		$user->destroy( $user->id );

		return redirect( $this->url )->with(
			[
				'status'  => 'success',
				'message' => __( 'Deleted %s', $title ),
			]
		);
	}
}
