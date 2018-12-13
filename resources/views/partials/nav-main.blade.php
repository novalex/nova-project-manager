<nav id="nav-main">
	<a href="{{ url( '/' ) }}" title="Nova Project Manager" id="logo">
		<img src="{{ asset( 'img/logo.png' ) }}" alt="Logo">
	</a>

	@php
		$default_menu_items = array(
			array(
				'url'     => '/',
				'name'    => __( 'Dashboard' ),
				'options' => '{ "icon": "fas fa-bars" }',
			),
			array(
				'url'     => '/settings',
				'name'    => __( 'Settings' ),
				'options' => '{ "icon": "fas fa-cog" }',
			),
		);

		$custom_menu_items = App\Menu::all();

		if ( ! count( $custom_menu_items ) ) {
			$custom_menu_items = array();
		}

		$menu_items = array_merge(
			$default_menu_items,
			$custom_menu_items
		);
	@endphp

	@if ( count( $menu_items ) )
		<ul id="nav-main-menu">
			@foreach ( $menu_items as $item )
				@php
					$options = json_decode( $item['options'], true );

					$icon = '';
					if ( isset( $options['icon'] ) ) {
						// FA icon.
						$icon = '<span class="icon ' . $options['icon'] . '"></span>';
					} elseif ( isset( $options['img'] ) ) {
						// Image icon.
						$icon = '<img class="icon" src="' . asset( 'svg/' . $options['img'] ) . '" alt="Icon">';
					}
				@endphp
				<li class="menu-item{{ ( \Request::is([ $item['url'], $item['url'] . '/*' ]) ) ? ' active' : '' }}">
					<a href="{{ url( $item['url'] ) }}">{!! $icon !!}{{ $item['name'] }}</a>
				</li>
			@endforeach
		</ul>
	@endif
</nav>