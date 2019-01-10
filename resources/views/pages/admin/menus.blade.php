
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
							<label for="url">{{ __( 'URL' ) }}</label>
							<div class="inputgroup">
								<span class="prefix">{{ url( '/' ) }}/</span>
								<input type="text" id="url" name="url" value="{{ old( 'url' ) }}">
							</div>
						</div>

						@foreach ( $menu_options as $option_id => $option )
							<div class="fieldset">
								<label for="options_{{ $option_id }}">{{ $option['label'] }}</label>

								@if ( 'select' === $option['type'] )
									<select id="options_{{ $option_id }}" name="options[{{ $option_id }}]">
										@foreach ( $option['choices'] as $choice )
											<option value="{{ $choice['value'] }}"{{ $choice['value'] === intval( old( 'options.' . $option_id ) ) ? ' selected="selected"' : '' }}>{{ $choice['label'] }}</option>
										@endforeach
									</select>
								@else
									<input type="{{ $option['type'] }}" id="options_{{ $option_id }}" name="options[{{ $option_id }}]" value="{{ old( 'options.' . $option_id ) }}">
								@endif
							</div>
						@endforeach

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

				<form method="POST" id="form-edit" name="form-edit" action="{{ url( "$url/{$menu->id}" ) }}">

					<div class="fieldgroup -post-meta">

						<div class="fieldset">
							<label for="name">{{ __( 'Name' ) }}</label>
							<input type="text" id="name" name="name" value="{{ $menu['name'] }}">
						</div>

						<div class="fieldset">
							<label for="url">{{ __( 'URL' ) }}</label>
							<div class="inputgroup">
								<span class="prefix">{{ url( '/' ) }}/</span>
								<input type="text" id="url" name="url" value="{{ $menu['url'] }}">
							</div>
						</div>

						@foreach ( $menu_options as $option_id => $option )
							<div class="fieldset">
								<label for="options_{{ $option_id }}">{{ $option['label'] }}</label>

								@if ( 'select' === $option['type'] )
									<select id="options_{{ $option_id }}" name="options[{{ $option_id }}]">
										@foreach ( $option['choices'] as $choice )
											<option value="{{ $choice['value'] }}"{{ $choice['value'] === $menu['options'][ $option_id ] ? ' selected="selected"' : '' }}>{{ $choice['label'] }}</option>
										@endforeach
									</select>
								@else
									<input type="{{ $option['type'] }}" id="options_{{ $option_id }}" name="options[{{ $option_id }}]" value="{{ $menu['options'][ $option_id ] }}">
								@endif
							</div>
						@endforeach

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

			<a href="{{ url( "$url/create " ) }}" class="button -green">{{ __( 'New Item' ) }}</a>

		@endsection

		@section('content')

			@if ( count( $menus ) )
				<div class="content-list -table -menus">
					@foreach ( $menus as $menu )
						<div class="item">

							<div class="title">
								<strong>{{ $menu['name'] }}</strong>
							</div>

							<div class="subtitle">
								<small>{{ url( $menu['url'] ) }}</small>
							</div>

							<div class="action">
								<a href="{{ url( "$url/{$menu['id']}/edit" ) }}" class="item-action action-edit">
									<i class="far fa-edit"></i>
								</a>
							</div>

							<div class="action">
								<form method="POST" action="{{ url( "$url/{$menu['id']}" ) }}">
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
					<p>{{ __( 'No menus created.' ) }}</p>
				</div>
			@endif

		@endsection

@endswitch
