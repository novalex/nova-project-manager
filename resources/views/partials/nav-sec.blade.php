
@isset ( $sec_menu_items )
	<nav id="nav-sec">
		<div class="menu-item half mobile-toggle-item">
			<a class="menu-link mobile-toggle open" href="#nav-sec">
				<span class="icon fas fa-bars"></span>
				{{ __( 'Menu' ) }}
			</a>
			<a class="menu-link mobile-toggle close" href="#">
				<span class="icon fas fa-times"></span>
				{{ __( 'Close' ) }}
			</a>
		</div>

		<div class="menu-items">
			@foreach ( $sec_menu_items as $item )
				<div class="menu-item {{ $item['class'] }}">
					<a class="menu-link" href="{{ url( $item['url'] ) }}">
						{{ $item['name'] }}
						@isset ( $item['desc'] )
							<small>{{ $item['desc'] }}</small>
						@endisset
					</a>
				</div>
			@endforeach
		</div>
	</nav>
@endisset
