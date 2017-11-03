@php
	$title = 'Manage ' . $category->name . ' projects';
@endphp

@extends('pages.projects.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'projects/create' ) }}" class="button -green">Create Project</a>
@endsection

@section('content')
	@isset ( $posts )
		<div class="content-grid">
			@foreach ( $posts as $project )
				<div class="grid-item">
					<a href="{{ url( 'projects/' . $project['slug'] ) }}">
						<strong class="title">{{ $project['name'] }}</strong>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>No projects in this folder.</p>
			<a href="{{ url( 'projects/create' ) }}" class="button -green">Create a Project</a>
		</div>
	@endisset
@endsection