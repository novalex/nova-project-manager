
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
			</div>

			<button class="button -green -submit">{{ __( 'Search' ) }}</button>
		</form>

		@if ( ! empty( $results ) )

			@include('partials.search-results')

		@endif

	</div>

@endsection
