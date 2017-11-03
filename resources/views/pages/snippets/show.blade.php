@php
	$title = $snippet->name;
@endphp

@extends('pages.snippets.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'snippets/' . $snippet->slug . '/edit' ) }}" class="button">Edit</a>
	
	<form method="POST" action="/snippets/{{ $snippet->slug }}">
		{{ csrf_field() }}
		{{ method_field( 'DELETE' ) }}
		<button class="button -red action-delete">Delete</button>
	</form>
@endsection

@section('content')
	<div class="single-content full">
		{!! $snippet->body !!}
	</div>
@endsection