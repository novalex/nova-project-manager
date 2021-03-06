
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( "{$url['index']}/{$post->slug}" ) }}" class="button">{{ __( 'Cancel' ) }}</a>
	<button form="form-edit" class="button -green -submit">{{ __( 'Update' ) }}</a>
@endsection

@section('content')
	<div class="single-edit wide">
		@if ( $errors->any() )
			<div class="alert -error">
				<ul>
					@foreach ( $errors->all() as $error )
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" id="form-edit" name="form-edit" action="{{ url( "{$url['index']}/{$post->slug}" ) }}">
			<div class="fieldgroup -post-meta">
				<div class="fieldset">
					<label for="name">{{ __( 'Name' ) }}</label>
					<input type="text" id="name" name="name" value="{{ $post->name }}">
				</div>

				<div class="fieldset">
					<label for="slug">{{ __( 'Slug' ) }}</label>
					<div class="inputgroup">
						<span class="prefix">{{ url( $url['index'] ) }}/</span>
						<input type="text" id="slug" name="slug" value="{{ $post->slug }}" class="filter-slug">
					</div>
				</div>

				<div class="fieldset">
					<label for="category">{{ __( 'Category' ) }}</label>
					<input type="text" id="category" name="category" value="{{ get_category_name( $post->category ) }}" list="categories">
					<datalist id="categories">
						@foreach ( get_categories( $post_type['id'] ) as $category )
							<option>{{ get_category_name( $category->id ) }}</option>
						@endforeach
					</datalist>
				</div>
			</div>

			<div class="fieldgroup -post-content">
				<div class="fieldset">
					<label for="body">{{ __( 'Content' ) }}</label>
					<div class="editor-wrap">
						<textarea id="body" name="body" rows="12" class="md-editable">{{ $post->body }}</textarea>
					</div>
				</div>
			</div>

			{{ csrf_field() }}

			{{ method_field('PUT') }}

			<a href="{{ url( "{$url['index']}/{$post->slug}" ) }}" class="button">{{ __( 'Cancel' ) }}</a>
			<button class="button -green -submit">{{ __( 'Update' ) }}</button>
		</form>
	</div>
@endsection
