<?php

namespace App\Http\Controllers;

use App\Snippet;
use Illuminate\Http\Request;

class SnippetController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'pages.snippets.index' );
	}

	/**
	 * Display a snippets folder.
	 *
	 * @param  string $folder
	 * @return \Illuminate\Http\Response
	 */
	public function index_folder( $_folder ) {
		$folders = \DB::table('snippets')->distinct()->pluck('folder');
		foreach ( $folders as $folder ) {
			if ( str_slug( $folder ) == $_folder ) {
				$snippets = Snippet::get()->where( 'folder', $folder );
			} else {
				$folder = $_folder;
			}
		}
		return view( 'pages.snippets.folder', compact( 'folder', 'snippets' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'pages.snippets.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate([
			'name'     => 'required|unique:snippets|max:255',
			'slug'     => 'unique:snippets',
			'body'     => 'required',
			'category' => 'alpha',
		]);

		$snippet = Snippet::create([
			'name'        => $request->name,
			'slug'        => empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug ),
			'body'        => $request->body,
			'category_id' => get_category_id( $request->category, 'snippet' ),
		]);

		return redirect( 'snippets/' . $snippet->slug )->with(
			[
				'status'  => 'success',
				'message' => 'Created ' . $snippet->name,
			]
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Snippet $snippet
	 * @return \Illuminate\Http\Response
	 */
	public function show( Snippet $snippet ) {
		return view( 'pages.snippets.show', compact( 'snippet' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Snippet $snippet
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Snippet $snippet ) {
		return view( 'pages.snippets.edit', compact( 'snippet' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Snippet             $snippet
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Snippet $snippet ) {
		$request->validate([
			'name'     => 'required|unique:snippets,name,' . $snippet->id . '|max:255',
			'slug'     => 'unique:snippets,slug,' . $snippet->id,
			'body'     => 'required',
			'category' => 'alpha',
		]);

		$snippet->update([
			'name'        => $request->name,
			'slug'        => empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug ),
			'body'        => $request->body,
			'category_id' => get_category_id( $request->category, 'snippet' ),
		]);

		return redirect( 'snippets/' . $snippet->slug )->with(
			[
				'status'  => 'success',
				'message' => 'Updated ' . $snippet->name,
			]
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Snippet $snippet
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Snippet $snippet ) {
		$title = $snippet->name;

		$snippet->destroy( $snippet->id );

		return redirect( 'snippets' )->with(
			[
				'status'  => 'success',
				'message' => 'Deleted ' . $title,
			]
		);
	}
}
