
@isset ( $sec_menu_items )
	<nav id="nav-sec">
		@foreach ( $sec_menu_items as $item )
			<div class="menu-item {{ $item['class'] }}">
				<a href="{{ url( $item['url'] ) }}">
					{{ $item['name'] }}
					@isset ( $item['desc'] )
						<small>{{ $item['desc'] }}</small>
					@endisset
				</a>
			</div>
		@endforeach
	</nav>
@endisset
