@isset ( $sec_menu_items )
	<nav id="nav-sec">
		@foreach ( $sec_menu_items as $item )
			<div class="menu-item{{ ( \Request::is( [ $item->url, $item->url . '/*' ] ) ) ? ' active' : '' }}">
				<a href="{{ url( $item->url ) }}">
					{{ $item->name }}
					@if ( $item->desc )
						<small>{{ $item->desc }}</small>
					@endif
				</a>
			</div>
		@endforeach
	</nav>
@endisset