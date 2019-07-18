@extends('layouts.app')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('content')

	<div class="auth-content small center">
		<form method="POST" action="{{ route('login') }}">
			@csrf

			<div class="fieldset">
				<label for="email">{{ __('Email') }}</label>

				<input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

				@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
			</div>

			<div class="fieldset">
				<label for="password">{{ __('Password') }}</label>

				<input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>

				@if ($errors->has('password'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif
			</div>

			<div class="fieldset checkbox">
				<div class="field checkbox">
					<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
					<label for="remember">{{ __('Remember Me') }}</label>
				</div>
			</div>

			<div class="fieldset actions">
				<button type="submit" class="button -green -submit">
					{{ __('Login') }}
				</button>

				@if ( Route::has('password.request') )
					<a class="no-color" href="{{ route('password.request') }}">
						{{ __('Forgot Your Password?') }}
					</a>
				@endif
			</div>
		</form>
	</div>

@endsection
