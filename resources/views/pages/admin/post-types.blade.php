
@extends('pages.admin.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@switch( $action )

	{{-- Create --}}
	@case( 'create' )
		@section('nav-top-actions')
			<a href="{{ url( $url ) }}" class="button">{{ __( 'Cancel' ) }}</a>
			<button form="form-create" class="button -green -submit">{{ __( 'Create' ) }}</a>
		@endsection

		@section('content')
			<div class="single-edit full">
				@if ( $errors->any() )
					<div class="alert -error">
						<ul>
							@foreach ( $errors->all() as $error )
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form method="POST" id="form-create" name="form-create" action="{{ url( $url ) }}">

					<div class="fieldgroup -post-meta">
						<div class="fieldset">
							<label for="name">{{ __( 'Name' ) }}</label>
							<input type="text" id="name" name="name" value="{{ old( 'name' ) }}">
						</div>

						<div class="fieldset">
							<label for="slug">{{ __( 'Slug' ) }}</label>
							<input type="text" id="slug" name="slug" class="filter-slug" value="{{ old( 'slug' ) }}">
						</div>

					</div>

					{{ csrf_field() }}

					<button class="button -green -submit">{{ __( 'Create' ) }}</button>
				</form>
			</div>
		@endsection

		@break

	{{-- Index --}}
	@default

		@section('nav-top-actions')
			<a href="{{ url( "$url/create " ) }}" class="button -green">{{ __( 'New Post Type' ) }}</a>
		@endsection

		@section('content')
			@if ( count( $post_types ) )
				<div class="content-list -grid">
					@foreach ( $post_types as $post_type )
						<div class="item">
							<div>
								<strong class="title">{{ $post_type['name'] }}</strong>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="no-content">
					<p>{{ __( 'No post types created.' ) }}</p>
				</div>
			@endif
		@endsection

@endswitch
