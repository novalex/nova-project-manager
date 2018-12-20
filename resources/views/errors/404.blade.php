@extends('errors.main')

@section('content')
	<div class="no-content">
		<h1>404</h1>

		<p>
			{{ __( 'Nothing here' ) }}
			<br>
			{{ $exception->getMessage() }}
		</p>
	</div>
@endsection