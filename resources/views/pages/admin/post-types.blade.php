
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
			<div class="single-edit">
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

	{{-- Edit --}}
	@case( 'edit' )

		@section('nav-top-actions')

			<a href="{{ url( $url ) }}" class="button">{{ __( 'Cancel' ) }}</a>
			<button form="form-edit" class="button -green -submit">{{ __( 'Update' ) }}</a>

		@endsection

		@section('content')

			<div class="single-edit">
				@if ( $errors->any() )
					<div class="alert -error">
						<ul>
							@foreach ( $errors->all() as $error )
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form method="POST" id="form-edit" name="form-edit" action="{{ url( "$url/{$post_type->id}" ) }}">

					<div class="fieldgroup -post-meta">

						<div class="fieldset">
							<label for="name">{{ __( 'Name' ) }}</label>
							<input type="text" id="name" name="name" value="{{ $post_type->name }}">
						</div>

						<div class="fieldset">
							<label for="slug">{{ __( 'Slug' ) }}</label>
							<input type="text" id="slug" name="slug" class="filter-slug" value="{{ $post_type->slug }}">
						</div>

					</div>

					{{ csrf_field() }}

					{{ method_field('PUT') }}

					<button class="button -green -submit">{{ __( 'Update' ) }}</button>

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
				<div class="content-list -table -post-types">
					@foreach ( $post_types as $post_type )
						<div class="item">

							<div class="title">
								<a href="{{ url( "$url/{$post_type['id']}/edit" ) }}" class="no-color">
									<strong>{{ $post_type['name'] }}</strong>
								</a>
							</div>

							<div class="action">
								<a href="{{ url( "$url/{$post_type['id']}/edit" ) }}" class="item-action action-edit">
									<i class="far fa-edit"></i>
								</a>
							</div>

							<div class="action">
								<form method="POST" action="{{ url( "$url/{$post_type['id']}" ) }}">
									{{ csrf_field() }} {{ method_field( 'DELETE' ) }}
									<button class="item-action action-delete">
										<i class="far fa-trash-alt"></i>
									</button>
								</form>
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
