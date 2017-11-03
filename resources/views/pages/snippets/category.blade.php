@php
	$title = 'Manage ' . $category->name . ' snippets';
@endphp

@extends('pages.snippets.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'snippets/create' ) }}" class="button -green">Create Snippet</a>
@endsection

@section('content')
	@isset ( $posts )
		<div class="content-grid">
			@foreach ( $posts as $snippet )
				<div class="grid-item">
					<a href="{{ url( 'snippets/' . $snippet['slug'] ) }}">
						<strong class="title">{{ $snippet['name'] }}</strong>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>No snippets in this folder.</p>
			<a href="{{ url( 'snippets/create' ) }}" class="button -green">Create a Snippet</a>
		</div>
	@endisset
@endsection