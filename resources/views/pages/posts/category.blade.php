
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'posts/create' ) }}" class="button -green">{{ __( 'New post' ) }}</a>
@endsection

@section('content')
	@isset ( $posts )
		<div class="content-list -grid">
			@foreach ( $posts as $post )
				<div class="item">
					<a href="{{ url( 'posts/' . $post['slug'] ) }}">
						<strong class="title">{{ $post['name'] }}</strong>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>{{ __( 'No posts in this folder.' ) }}</p>
		</div>
	@endisset
@endsection