<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class AdminUserController extends AdminCrudController {

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'admin/users';

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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate(
			array(
				'name'     => 'required|string|max:255',
				'email'    => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6',
			)
		);

		$user = User::create(
			array(
				'name'     => $request->name,
				'email'    => $request->email,
				'password' => bcrypt( $request->password ),
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
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @param  \App\User                $user    Model.
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, User $user ) {
		$validate_fields = array(
			'name'  => 'required|string|max:255',
			'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
		);

		$update_fields = array(
			'name'  => $request->name,
			'email' => $request->email,
		);

		if ( ! empty( $request->password ) ) {
			$validate_fields['password'] = 'required|string|min:6';
			$update_fields['password']   = bcrypt( $request->password );
		}

		$request->validate( $validate_fields );
		$user->update( $update_fields );

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Updated %s' ), $user->name ),
			)
		);
	}

	/**
	 * Get the items to display.
	 *
	 * @return mixed
	 */
	public function getItems() {
		return User::all();
	}

	/**
	 * Get a single item by ID.
	 *
	 * @param int $id The ID of the item to fetch.
	 * @return mixed
	 */
	public function getItem( int $id ) {
		return User::where( 'id', $id )->first();
	}

	/**
	 * Get array of fields for create and edit views.
	 *
	 * @param int $user_id ID of the current user item.
	 * @return array
	 */
	public function getFields( int $user_id = 0 ) {
		return array(
			'name'  => array(
				'type'  => 'text',
				'label' => __( 'Name' ),
			),
			'email' => array(
				'type'  => 'text',
				'label' => __( 'Email' ),
			),
			'password' => array(
				'type'  => 'password',
				'label' => __( 'Password' ),
			),
		);
	}
}
