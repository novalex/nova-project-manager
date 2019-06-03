
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

					<div class="fieldgroup">

						@foreach ( $fields as $field_id => $field )
							<div class="fieldset">
								<label for="options_{{ $field_id }}">{{ $field['label'] }}</label>

								@if ( 'select' === $field['type'] )
									<select id="options_{{ $field_id }}" name="options[{{ $field_id }}]">
										@foreach ( $field['choices'] as $choice )
											<option value="{{ $choice['value'] }}"{{ $choice['value'] === intval( old( 'options.' . $field_id ) ) ? ' selected="selected"' : '' }}>{{ $choice['label'] }}</option>
										@endforeach
									</select>
								@else
									<input type="{{ $field['type'] }}" id="options_{{ $field_id }}" name="options[{{ $field_id }}]" value="{{ old( 'options.' . $field_id ) }}">
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

				<form method="POST" id="form-edit" name="form-edit" action="{{ url( "$url/{$item->id}" ) }}">

					<div class="fieldgroup -post-meta">

						@foreach ( $fields as $field_id => $field )
							@php
								if ( ! empty( $field['group'] ) ) {
									$field_name  = $field['group'] . "[{$field_id}]";
									$field_value = ( isset( $item[ $field['group'] ][ $field_id ] ) ) ? $item[ $field['group'] ][ $field_id ] : '';
								} else {
									$field_name  = $field_id;
									$field_value = isset( $item[ $field_id ] ) ? $item[ $field_id ] : '';
								}
							@endphp
							<div class="fieldset">
								<label for="{{ $field_id }}">{{ $field['label'] }}</label>

								@if ( 'select' === $field['type'] )
									<select id="{{ $field_id }}" name="{{ $field_name }}">
										@foreach ( $field['choices'] as $choice )
											<option value="{{ $choice['value'] }}"{{ $choice['value'] === $field_value ? ' selected="selected"' : '' }}>{{ $choice['label'] }}</option>
										@endforeach
									</select>
								@else
									<div class="inputgroup">
										@if ( ! empty( $field['prefix'] ) )
											<span class="prefix">{{ url( '/' ) }}/</span>
										@endif
										<input type="{{ $field['type'] }}" id="{{ $field_id }}" name="{{ $field_name }}" value="{{ $field_value }}">
									</div>
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

			<a href="{{ url( "$url/create " ) }}" class="button -green">{{ sprintf( __( 'New %s' ), ucfirst( $strings['singular'] ) ) }}</a>

		@endsection

		@section('content')

			@if ( count( $items ) )
				<div class="content-list -table">
					@foreach ( $items as $item )
						<div class="item">

							<div class="title">
								<a href="{{ url( "$url/{$item['id']}/edit" ) }}" class="no-color">
									<strong>{{ $item['name'] }}</strong>
									<small class="subtitle">{{ url( $item['url'] ) }}</small>
								</a>
							</div>

							<div class="action">
								<a href="{{ url( "$url/{$item['id']}/edit" ) }}" class="item-action action-edit">
									<i class="far fa-edit"></i>
								</a>
							</div>

							<div class="action">
								<form method="POST" action="{{ url( "$url/{$item['id']}" ) }}">
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
					<p>{{ sprintf( __( 'No %s created.' ), $strings['singular'] ) }}</p>
				</div>
			@endif

		@endsection

@endswitch
