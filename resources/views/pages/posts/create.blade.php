
@extends('pages.posts.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( $url['index'] ) }}" class="button">{{ __( 'Cancel' ) }}</a>
	<button form="form-create" class="button -green -submit">{{ __( 'Create' ) }}</a>
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

		<form method="POST" id="form-create" name="form-create" action="{{ url( $url['index'] ) }}">

			<div class="fieldgroup -post-meta">
				<div class="fieldset">
					<label for="name">{{ __( 'Name' ) }}</label>
					<input type="text" id="name" name="name" value="{{ old( 'name' ) }}">
				</div>

				<div class="fieldset">
					<label for="slug">{{ __( 'Slug' ) }}</label>
					<div class="inputgroup">
						<span class="prefix">{{ url( $url['index'] ) }}/</span>
						<input type="text" id="slug" name="slug" class="filter-slug" value="{{ old( 'slug' ) }}">
					</div>
				</div>

				<div class="fieldset">
					<label for="category">{{ __( 'Category' ) }}</label>
					<input type="text" id="category" name="category" value="{{ old( 'category' ) }}" list="categories">
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
						<textarea id="body" name="body" rows="12" class="md-editable">{{ old( 'body' ) }}</textarea>
					</div>
				</div>
			</div>

			{{ csrf_field() }}

			<button class="button -green -submit">{{ __( 'Create' ) }}</button>
		</form>
	</div>

@endsection
