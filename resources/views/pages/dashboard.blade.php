@extends('layouts.app')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('content')

<div class="container dummy">
	<h3>Hello, [FATAL_ERR_UNDEFINED]</h3>

	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
		dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
		non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing
		elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
		ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
		mollit anim id est laborum.
	</p>

	<h4>{{ __( 'Bitchin\' Stats' ) }}</h4>

	<div class="content-list -grid -stats">
		@foreach ( $stats as $stat )
			<div class="item">
				<a href="{{ $stat['url'] }}">
					<strong class="title">{{ $stat['title'] }}</strong>
					<small class="subtitle">{{ $stat['number'] }}</small>
					<i class="icon bg-icon {{ $stat['icon'] }}"></i>
				</a>
			</div>
		@endforeach
	</div>

</div>

@endsection
