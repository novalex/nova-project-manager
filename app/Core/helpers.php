<?php

/**
 * Get category name by ID.
 *
 * @param int $id The category ID.
 * @return string
 */
function get_category( $id ) {
	$category = DB::table( 'categories' )->where( 'id', $id )->first();

	return ( isset( $category->name ) ) ? $category->name : '';
}

/**
 * Generate a category by name or return existing category's ID.
 *
 * @param string $name      The category name.
 * @param int    $post_type The post type ID.
 * @return int The category ID.
 */
function get_category_id( string $name, int $post_type = null ) {
	$category = App\Category::firstOrNew(
		array(
			'name'      => $name,
			'post_type' => $post_type,
		)
	);

	if ( $category->exists ) {
		return $category->id;
	} else {
		$category->slug = str_slug( $name );

		if ( $post_type ) {
			$category->post_type = $post_type;
		}

		$category->save();

		return $category->id;
	}
}

/**
 * Get categories by type.
 *
 * @param string $type The category type.
 * @return mixed
 */
function get_categories( $type ) {
	return DB::table( 'categories' )->where( 'post_type', $type )->get();
}

/**
 * Get array of nav items for a specific menu.
 *
 * @param string $menu The menu ID.
 * @param array  $args Additional args for the menu and items.
 * @return array
 */
function get_nav_menu_items( $menu, $args = [] ) {
	$items = array();

	switch ( $menu ) {

		// Main menu.
		case 'main':
			$default_primary_menu_items = array(
				array(
					'url'     => '/',
					'name'    => __( 'Dashboard' ),
					'options' => array(
						'icon' => 'fas fa-bars',
					),
				),
				array(
					'url'     => 'admin',
					'name'    => __( 'Settings' ),
					'options' => array(
						'icon' => 'fas fa-cog',
					),
				),
			);

			$primary_menu_items = App\Menu::all()->toArray();

			if ( ! count( $primary_menu_items ) ) {
				$primary_menu_items = array();
			}

			foreach ( array_merge(
				$default_primary_menu_items,
				$primary_menu_items
			) as $_item ) {
				$class = array();

				if ( isset( $_item['options']['class'] ) ) {
					$class[] = $_item['options']['class'];
				}

				if ( \Request::is( array( $_item['url'], $_item['url'] . '/*' ) ) ) {
					$class[] = 'active';
				}

				$icon = '';
				if ( isset( $_item['options']['icon'] ) ) {
					// FA icon.
					$icon = '<span class="icon ' . $_item['options']['icon'] . '"></span>';
				} elseif ( isset( $_item['options']['img'] ) ) {
					// Image icon.
					$icon = '<img class="icon" src="' . asset( 'svg/' . $_item['options']['img'] ) . '" alt="Icon">';
				}

				if ( ! empty( $icon ) ) {
					$class[] = 'has-icon';
				}

				$class = ' ' . implode( ' ', $class );

				$items[] = array(
					'name'  => $_item['name'],
					'url'   => $_item['url'],
					'class' => $class,
					'icon'  => $icon,
				);
			}

			break;

		// Categories menu.
		case 'categories':
			$categories = get_categories( $args['post_type'] );

			if ( $categories ) {
				$items[] = array_merge(
					[
						'name' => __( 'All' ),
						'url'  => str_plural( $args['post_type'] ),
					],
					$args['item_args']
				);

				foreach ( $categories as $category ) {
					$items[] = array_merge(
						[
							'name' => $category->name,
							'url'  => str_plural( $args['post_type'] ) . '/category/' . $category->slug,
						],
						$args['item_args']
					);
				}
			}

			break;

	}

	return $items;
}
