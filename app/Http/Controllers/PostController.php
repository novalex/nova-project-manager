<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PostController extends Controller {

	/**
	 * The post type of the current resource.
	 *
	 * @var string
	 */
	public $post_type = 'post';

	/**
	 * Array of strings describing the resource.
	 *
	 * @var array
	 */
	public $strings = array(
		'singular' => 'post',
		'plural'   => 'posts',
	);

	/**
	 * Array of views for displaying and modifying the resource.
	 *
	 * @var array
	 */
	public $views = array(
		'index'  => 'pages.posts.index',
		'create' => 'pages.posts.create',
		'show'   => 'pages.posts.show',
		'edit'   => 'pages.posts.edit',
	);

	/**
	 * Resource's URL slug.
	 *
	 * @var string
	 */
	public $url = 'posts';

	/**
	 * Constructor.
	 */
	public function __construct() {
		\View::share( 'url', array(
			'index'  => $this->url,
			'create' => "{$this->url}/create",
		) );

		\View::share( 'post_type', $this->post_type );

		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view(
			$this->views['index'],
			array(
				'title' => sprintf( __( 'Manage %s' ), $this->strings['plural'] ),
				'posts' => Post::all(),
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
			$this->views['create'],
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
				'name'     => 'required|unique:posts|max:255',
				'slug'     => 'unique:posts',
				'body'     => 'required',
				'category' => 'alpha',
			)
		);

		$slug = empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug );

		$post = Post::create(
			array(
				'name'      => $request->name,
				'slug'      => $slug,
				'body'      => $request->body,
				'category'  => get_category_id( $request->category, $this->post_type['id'] ),
				'post_type' => $this->post_type['id'],
			)
		);

		return redirect( "{$this->url}/{$post->slug}" )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Created %s' ), $post->name ),
			)
		);
	}

	/**
	 * Display a post.
	 *
	 * @param  \App\Post $post Model.
	 * @return \Illuminate\Http\Response
	 */
	public function show( Post $post ) {
		return view(
			$this->views['show'],
			array(
				'title'   => $post->name,
				'post'    => $post,
				'content' => ( new \Parsedown() )->text( $post->body ),
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Post $post Model.
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Post $post ) {
		return view(
			$this->views['edit'],
			array(
				'post'  => $post,
				'title' => sprintf( __( 'Edit %s' ), $post->name ),
			)
		);
	}

	/**
	 * Update the specified resource.
	 *
	 * @param  \Illuminate\Http\Request $request Request object.
	 * @param  \App\Post                $post    Model.
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Post $post ) {
		$request->validate(
			array(
				'name'     => 'required|unique:posts,name,' . $post->id . '|max:255',
				'slug'     => 'unique:posts,slug,' . $post->id,
				'body'     => 'required',
				'category' => 'alpha',
			)
		);

		$slug = empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug );

		$post->update(
			array(
				'name'     => $request->name,
				'slug'     => $slug,
				'body'     => $request->body,
				'category' => get_category_id( $request->category, $this->post_type['id'] ),
			)
		);

		return redirect( "{$this->url}/{$post->slug}" )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Updated %s' ), $post->name ),
			)
		);
	}

	/**
	 * Remove the specified resource.
	 *
	 * @param  \App\Post $post Model.
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Post $post ) {
		$title = $post->name;

		$post->destroy( $post->id );

		return redirect( $this->url )->with(
			array(
				'status'  => 'success',
				'message' => sprintf( __( 'Deleted %s' ), $title ),
			)
		);
	}
}
