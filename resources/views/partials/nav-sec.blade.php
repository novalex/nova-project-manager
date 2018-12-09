@isset ( $sec_menu_items )
	<nav id="nav-sec">
		@foreach ( $sec_menu_items as $item )
			@php
				$class = ' ';
				if ( isset( $item['class'] ) ) {
					$class .= $item['class'];
				}
				if ( \Request::is( [ $item['url'], $item['url'] . '/' ] ) ) {
					$class .= ' active';
				}
			@endphp
			<div class="menu-item{{ $class }}">
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