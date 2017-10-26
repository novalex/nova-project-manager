@php
	$title = 'Manage projects';
@endphp

@extends('pages.projects.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'projects/create' ) }}" class="button button-green">Create Project</a>
@endsection

@section('content')
	Projects here lol
@endsection