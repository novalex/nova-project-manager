
<div class="search-results">

	@if ( ! empty( $results['items'] ) )
		<ul>
			@foreach ( array_reverse( $results['items'] ) as $group => $items )
				<li class="group">
					<strong>{{ $group }}</strong>

					<ul class="items">

						@foreach ( $items as $result )
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
							</li>
						@endforeach

					</ul>

				</li>
			@endforeach

			@if ( ! empty( $results['links'] ) )
				{{ $results['links'] }}
			@endif

		</ul>
	@else
		<p>{{ __( 'No results found.' ) }}</p>
	@endif

</div>
