<nav id="nav-main">
	<a href="{{ url( '/' ) }}" title="Nova Project Manager" id="logo">
		<img src="{{ asset( 'img/logo.png' ) }}" alt="Logo">
	</a>

	@php
		$menu_items = App\Menu::all();
	@endphp

	@if ( count( $menu_items ) )
		<ul id="nav-main-menu">
			@foreach ( $menu_items as $item )
				@php
					$options = json_decode( $item['options'], true );

					$icon = '';
					if ( isset( $options['icon'] ) ) {
						$icon = '<img src="' . asset( 'svg/' . $options['icon'] ) . '" alt="Icon">';
					}
				@endphp
				<li class="menu-item{{ ( \Request::is([ $item['url'], $item['url'] . '/*' ]) ) ? ' active' : '' }}">
					<a href="{{ url( $item['url'] ) }}">{!! $icon !!}{{ $item['name'] }}</a>
				</li>
			@endforeach
		</ul>
	@endif
</nav>