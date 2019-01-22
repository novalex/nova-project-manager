
@extends('pages.admin.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('content')
	<div class="single-content full">

		<form method="POST" id="form-create" name="form-create" action="{{ url( 'admin/settings' ) }}">
			@foreach ( $fields as $field_id => $field )
				<fieldset>
					<label for="setting_{{ $field_id }}">{{ $field['label'] }}</label>
					<input type="{{ $field['type'] }}" id="setting_{{ $field_id }}" name="setting_{{ $field_id }}">
				</fieldset>
			@endforeach
		</form>

	</div>
@endsection
