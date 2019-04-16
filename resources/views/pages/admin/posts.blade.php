
@extends('pages.admin.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'admin/post-types' ) }}" class="button">{{ __( 'Post Types' ) }}</a>
@endsection

@section('content')
	@if ( count( $post_types ) )
		<div class="content-list -grid">
			@foreach ( $post_types as $post_type )
				<div class="item">
					<a href="{{ url( "{$url['index']}/{$post_type['slug']}" ) }}">
						<strong class="title">{{ $post_type['name'] }}</strong>
						<small class="subtitle">{{ get_category_name( $post_type->category ) }}</small>
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
