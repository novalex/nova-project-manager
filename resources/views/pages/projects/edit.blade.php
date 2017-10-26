@php
	$title = 'Edit "' . $project->name . '"';

	$defaultData = json_encode([
		'navTopTitle' => $project->name,
		'navTopSubtitle' => $project->slug,
	]);
@endphp

@extends('pages.projects.main')

@section('nav-top-title')
	<transition appear>
		<strong v-if="navTopTitle">Edit "@{{ navTopTitle }}"</strong>
		<strong v-else>{{ $title }}</strong>
	</transition>
@endsection

@section('nav-top-actions')
	<a href="/projects/{{ $project->slug }}" class="button">Cancel</a>
	<form method="POST" action="/projects/{{ $project->slug }}">
		{{ csrf_field() }}
		{{ method_field( 'DELETE' ) }}
		<button class="button button-red action-delete">Delete</button>
	</form>
	<button form="form-edit" class="button button-green button-submit">Update</a>
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

	<form method="POST" id="form-edit" name="form-edit" action="/projects/{{ $project->slug }}">
		<div class="fieldset">
			<label for="name">Name</label>
			<input type="text" name="name" v-model="navTopTitle" value="{{ $project->name }}">
		</div>

		<div class="fieldset">
			<div class="fieldgroup">
				<span class="prefix">{{ url( '/projects' ) }}/</span>
				<input type="text" name="slug" value="{{ $project->slug }}" class="filter-slug">
			</div>
		</div>

		<div class="fieldset">
			<label for="type">Type</label>
			<input type="text" name="type" value="{{ $project->type }}" list="project-types">
			<datalist id="project-types">
				@foreach ( DB::table('projects')->distinct()->pluck('type') as $type )
					<option>{{ $type }}</option>
				@endforeach
			</datalist>
		</div>

		<div class="fieldset">
			<label for="body">Content</label>
			<textarea name="body" rows="12">{{ $project->body }}</textarea>
		</div>

		{{ csrf_field() }}

		{{ method_field('PUT') }}

		<button class="button button-green button-submit">Update</a>
	</form>
@endsection