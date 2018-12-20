
@extends('pages.admin.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'admin/users/create' ) }}" class="button -green">{{ __( 'New User' ) }}</a>
@endsection

@section('content')
	@php
		$users = array();
	@endphp

	@if ( count( $users ) )
		<div class="content-list -grid">
			@foreach ( $users as $user )
				<div class="item">
					<a href="{{ url( 'user/' . $user['id'] ) }}">
						<strong class="title">{{ $user['name'] }}</strong>
						<small class="subtitle">{{ $user['role'] }}</small>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>{{ __( 'No users available.' ) }}</p>
		</div>
	@endif
@endsection
