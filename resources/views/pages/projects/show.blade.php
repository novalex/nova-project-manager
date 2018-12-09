@php
	$title = $project->name;

	$Parsedown = new Parsedown();

	$content = $Parsedown->text( $project->body );
@endphp

@extends('pages.projects.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ action('ProjectController@edit', $project->slug) }}" class="button">Edit</a>

	<form method="POST" action="/projects/{{ $project->slug }}">
		{{ csrf_field() }}
		{{ method_field( 'DELETE' ) }}
		<button class="button -red action-delete">Delete</button>
	</form>
@endsection

@section('content')
	<div class="single-content full">
		<div id="post-body">
			{!! $content !!}
		</div>
	</div>
@endsection