@extends('layouts.app')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('content')

	<div class="auth-content small center">
		@if ($errors->has('email'))
			<ul class="alert -error">
				<li role="alert">{{ $errors->first('email') }}</li>
			</ul>
		@endif

		<form method="POST" action="{{ route('password.email') }}">
			@csrf

			<div class="fieldset">
				<label for="email">{{ __('Email') }}</label>

				<input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
			</div>

			<div class="fieldset actions">
				<button type="submit" class="button -submit">
					{{ __('Send Password Reset Link') }}
				</button>
			</div>
		</form>
	</div>

@endsection
