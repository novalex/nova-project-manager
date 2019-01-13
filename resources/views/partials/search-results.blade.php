
<div class="search-results">
	@if ( $results )
		<ul>
			@foreach ( $results as $result )
				<li>
					@if ( $result['name'] )
						<strong>{!! $result['name'] !!}</strong>
					@endif
					@if ( $result['body'] )
						<p>{!! $result['body'] !!}</p>
					@endif
					@if ( $result['type'] )
						<small>{{ $result['type'] }}</small>
					@endif
			@endforeach
			<li>
				<strong><em>WordPress</em></strong>
				<small>Projects Category</small>
			</li>
			<li>
				<strong><em>WordPress</em></strong>
				<small>Snippets Category</small>
			</li>
			<li>
				<strong>Force SSL in <em>WordPress</em></strong>
				<small>Snippet</small>
			</li>
		</ul>
	@else
		<p>{{ __( 'No results found.' ) }}</p>
	@endif
</div>
