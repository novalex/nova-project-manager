<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'pages.projects.index' );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'pages.projects.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate([
			'name'     => 'required|unique:projects|max:255',
			'slug'     => 'unique:projects',
			'body'     => 'required',
			'category' => 'alpha',
		]);

		$project = Project::create([
			'name'        => $request->name,
			'slug'        => empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug ),
			'body'        => $request->body,
			'category_id' => get_category_id( $request->category, 'project' ),
		]);

		return redirect( 'projects/' . $project->slug )->with(
			[
				'status'  => 'success',
				'message' => 'Created ' . $project->name,
			]
		);
	}

	/**
	 * Display a project.
	 *
	 * @param  \App\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function show( Project $project ) {
		return view( 'pages.projects.show', compact( 'project' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Project $project ) {
		return view( 'pages.projects.edit', compact( 'project' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Project             $project
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Project $project ) {
		$request->validate([
			'name'     => 'required|unique:projects,name,' . $project->id . '|max:255',
			'slug'     => 'unique:projects,slug,' . $project->id,
			'body'     => 'required',
			'category' => 'alpha',
		]);

		$project->update([
			'name'        => $request->name,
			'slug'        => empty( $request->slug ) ? str_slug( $request->name ) : str_slug( $request->slug ),
			'body'        => $request->body,
			'category_id' => get_category_id( $request->category, 'project' ),
		]);

		return redirect( 'projects/' . $project->slug )->with(
			[
				'status'  => 'success',
				'message' => 'Updated ' . $project->name,
			]
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Project $project ) {
		$title = $project->name;

		$project->destroy( $project->id );

		return redirect( 'projects' )->with(
			[
				'status'  => 'success',
				'message' => 'Deleted ' . $title,
			]
		);
	}
}
