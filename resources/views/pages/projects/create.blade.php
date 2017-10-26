@php
	$title = 'New Project';

	$defaultData = json_encode([
		'navTopTitle' => old('name'),
		'navTopSubtitle' => old('slug'),
	]);
@endphp

@extends('pages.projects.main')

@section('nav-top-title')
	<transition appear>
		<strong v-if="navTopTitle">@{{ navTopTitle }}</strong>
		<strong v-else>{{ $title }}</strong>
	</transition>
@endsection

@section('nav-top-actions')
	<a href="/projects" class="button">Cancel</a>
	<button form="form-create" class="button button-green button-submit">Create</a>
@endsection

@section('content')
	@if ( $errors->any() )
		<div class="alert alert-error">
			<ul>
				@foreach ( $errors->all() as $error )
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form method="POST" id="form-create" name="form-create" action="/projects">
		<div class="fieldset">
			<label for="name">Name</label>
			<input type="text" name="name" v-model="navTopTitle" v-send-value send-value-class="project-slug" value="{{ old('name') }}">
		</div>

		<div class="fieldset">
			<div class="fieldgroup">
				<span class="prefix">{{ url( '/projects' ) }}/</span>
				<input type="text" name="slug" class="filter-slug" value="{{ old('slug') }}">
			</div>
		</div>

		<div class="fieldset">
			<label for="type">Type</label>
			<input type="text" name="type" value="{{ old('type') }}">
			<datalist id="project-types">
				@foreach ( DB::table('projects')->distinct()->pluck('type') as $type )
					<option>{{ $type }}</option>
				@endforeach
			</datalist>
		</div>

		<div class="fieldset">
			<label for="body">Content</label>
			<textarea name="body" rows="12">{{ old('body') }}</textarea>
		</div>

		{{ csrf_field() }}

		<button class="button button-green button-submit">Create</a>
	</form>
@endsection