
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( $url['create'] ) }}" class="button -green">{{ sprintf( __( 'New %s' ), $strings['singular'] ) }}</a>
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
			<p>{{ sprintf( __( 'No %s.' ), $strings['plural'] ) }}</p>
		</div>
	@endif
@endsection
