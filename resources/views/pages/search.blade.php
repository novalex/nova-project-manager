
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('content')

	<div class="single-content">
		<form method="GET" id="form-search" name="form-search" action="{{ url( 'search' ) }}">

			<div class="fieldgroup -search-filters">

				<div class="fieldset">
					<label for="query">{{ __( 'Keywords' ) }}</label>
					<input type="text" id="query" name="query" value="{{ request()->input( 'query' ) }}" placeholder="{{ __( 'Search...' ) }}">
				</div>

				<hr>

				<div class="fieldset inline">
					<label>{{ __( 'Objects' ) }}</label>

					@foreach ( [ 'Post', 'Post Type', 'Category' ] as $object )
						<div class="field checkbox">
							<input type="checkbox" mame="objects[]" id="object_{{ str_slug( $object ) }}" value="{{ str_slug( $object ) }}">
							<label for="object_{{ str_slug( $object ) }}">{{ str_plural( $object ) }}</label>
						</div>
					@endforeach
				</div>

				<hr>

				<div class="fieldset inline">
					<label>{{ __( 'Post Types' ) }}</label>

					@foreach ( get_post_types() as $post_type )
						<div class="field checkbox">
							<input type="checkbox" mame="post_types[]" id="post_type_{{ $post_type['id'] }}" value="{{ $post_type['id'] }}">
							<label for="post_type_{{ $post_type['id'] }}">{{ str_plural( $post_type['name'] ) }}</label>
						</div>
					@endforeach
				</div>

				<hr>

			</div>

			<button class="button -green -submit">{{ __( 'Search' ) }}</button>
		</form>

		@if ( ! empty( $results ) )

			@include('partials.search-results')

		@endif

	</div>

@endsection
