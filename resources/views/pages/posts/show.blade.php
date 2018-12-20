
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( "{$url['index']}/{$post->slug}/edit" ) }}" class="button">{{ __( 'Edit' ) }}</a>

	<form method="POST" action="{{ url( "{$url['index']}/{$post->slug}" ) }}">
		{{ csrf_field() }}
		{{ method_field( 'DELETE' ) }}
		<button class="button -red action-delete">{{ __( 'Delete' ) }}</button>
	</form>
@endsection

@section('content')
	<div class="single-content full">
		<div id="post-body">
			{!! $content !!}
		</div>
	</div>
@endsection
