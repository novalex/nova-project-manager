<nav id="nav-main">

	<ul id="nav-main-menu">
		@foreach ( get_nav_menu_items( 'main' ) as $item )
			<li class="menu-item{{ $item['class'] }}">
				<a href="{{ url( $item['url'] ) }}">{!! $item['icon'] !!}{{ $item['name'] }}</a>
			</li>
		@endforeach
	</ul>

</nav>