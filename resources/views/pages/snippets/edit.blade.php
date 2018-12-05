@php
	$title = 'Edit "' . $snippet->name . '"';

	$defaultData = json_encode([
		'navTopTitle' => $snippet->name,
		'navTopSubtitle' => $snippet->slug,
	]);
@endphp

@extends('pages.snippets.main')

@section('nav-top-title')
	<transition name="appear">
		<strong v-if="navTopTitle">Edit "@{{ navTopTitle }}"</strong>
		<strong v-else>{{ $title }}</strong>
	</transition>
@endsection

@section('nav-top-actions')
	<a href="/snippets/{{ $snippet->slug }}" class="button">Cancel</a>
	<form method="POST" action="/snippets/{{ $snippet->slug }}">
		{{ csrf_field() }}
		{{ method_field( 'DELETE' ) }}
		<button class="button -red action-delete">Delete</button>
	</form>
	<button form="form-edit" class="button -green -submit">Update</a>
@endsection

@section('content')
	<div class="single-edit full">
		@if ( $errors->any() )
			<div class="alert -error">
				<ul>
					@foreach ( $errors->all() as $error )
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" id="form-edit" name="form-edit" action="/snippets/{{ $snippet->slug }}">
			<div class="fieldgroup -post-meta">
				<div class="fieldset">
					<label for="name">Name</label>
					<input type="text" id="name" name="name" v-model="navTopTitle" value="{{ $snippet->name }}">
				</div>

				<div class="fieldset">
					<label for="slug">Slug</label>
					<div class="inputgroup">
						<span class="prefix">{{ url( '/snippets' ) }}/</span>
						<input type="text" id="slug" name="slug" value="{{ $snippet->slug }}" class="filter-slug">
					</div>
				</div>

				<div class="fieldset">
					<label for="category">Category</label>
					<input type="text" id="category" name="category" value="{{ get_category( $snippet->category_id ) }}" list="categories">
					<datalist id="categories">
						@foreach ( get_categories( 'snippet' ) as $category )
							<option>{{ $category->name }}</option>
						@endforeach
					</datalist>
				</div>
			</div>

			<div class="fieldgroup -post-content">
				<div class="fieldset">
					<label for="body">Content</label>
					<editor el-id="body" name="body" rows="12" content="{{ $snippet->body }}"></editor>
					<!-- <textarea id="body" name="body" rows="12" class="editable">{{ $snippet->body }}</textarea> -->
				</div>
			</div>

			{{ csrf_field() }}

			{{ method_field('PUT') }}

			<button class="button -green -submit">Update</button>
		</form>
	</div>
@endsection