<nav id="nav-main">

	<a href="{{ url( '/' ) }}" title="{{ config( 'app.name' ) . ' - ' . __( 'Homepage' ) }}" id="logo">
		<img src="{{ asset( 'img/logo.png' ) }}" alt="Logo">
	</a>

	<ul id="nav-main-menu">
		@foreach ( get_nav_menu_items( 'main' ) as $item )
			<li class="menu-item{{ $item['class'] }}">
				<a href="{{ url( $item['url'] ) }}">
					{!! $item['icon'] !!}
					<small>{{ $item['name'] }}</small>
				</a>
			</li>
		@endforeach
	</ul>

</nav>
