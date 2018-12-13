
@extends('pages.snippets.main')

@section('nav-top-title')
	{{ $title }}
@endsection

@section('nav-top-actions')
	<a href="{{ url( 'snippets/create' ) }}" class="button -green">Create Snippet</a>
@endsection

@section('content')
	@if ( count( $snippets ) )
		<div class="content-grid">
			@foreach ( $snippets as $snippet )
				<div class="grid-item">
					<a href="{{ url( 'snippets/' . $snippet['slug'] ) }}">
						<strong class="title">{{ $snippet['name'] }}</strong>
						<small class="subtitle">{{ get_category( $snippet['category_id'] ) }}</small>
					</a>
				</div>
			@endforeach
		</div>
	@else
		<div class="no-content">
			<p>No snippets created.</p>
			<a href="{{ url( 'snippets/create' ) }}" class="button -green">Create a Snippet</a>
		</div>
	@endif
@endsection
