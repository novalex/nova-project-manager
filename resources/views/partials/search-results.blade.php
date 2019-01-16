
<div class="search-results hide-on-blur">

	@if ( $results )
		<ul>

			@foreach ( $results as $result )
				<li>
					<a href="{{ $result['link'] }}">
						@if ( ! empty( $result['name'] ) )
							<strong>{!! $result['name'] !!}</strong>
						@endif
						@if ( ! empty( $result['body'] ) )
							<p>{!! $result['body'] !!}</p>
						@endif
						@if ( ! empty( $result['type'] ) )
							<small>{{ $result['type'] }}</small>
						@endif
					</a>
			@endforeach

		</ul>
	@else
		<p>{{ __( 'No results found.' ) }}</p>
	@endif

</div>
