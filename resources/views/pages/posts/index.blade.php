
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( $url['create'] ) }}" class="button -green">{{ __( 'New Post' ) }}</a>
@endsection

@section('content')
	@if ( count( $posts ) )
		<div class="content-list -grid">
			@foreach ( $posts as $post )
				<div class="item">
					<a href="{{ url( "{$url['index']}/{$post['slug']}" ) }}">
						<strong class="title">{{ $post['name'] }}</strong>
						<small class="subtitle">{{ get_category( $post->category ) }}</small>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>{{ __( 'No posts created.' ) }}</p>
		</div>
	@endif
@endsection
