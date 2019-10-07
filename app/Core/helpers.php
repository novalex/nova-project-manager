<?php

use App\Category;
use App\PostType;

/**
 * Get category name by ID.
 *
 * @param int    $id        The category ID.
 * @param string $separator String to use as separator.
 * @return string
 */
function get_category_name( $id, $separator = '/' ) {
	$category = Category::where( 'id', $id )->first();

	if ( ! $category ) {
		return;
	}

	$name = $category->name;

	while ( $category->parent ) {
		$category = Category::where( 'id', $category->parent )->first();

		if ( $category ) {
			$name = "{$category->name}{$separator}{$name}";
		}
	}

	return $name;
}

/**
 * Generate a category by name or return existing category's ID.
 *
 * @param string $name      The category name.
 * @param int    $post_type The post type ID.
 * @return int The category ID.
 */
function get_category_id( string $name, int $post_type = null ) {
	// Split categories separated by forward slash.
	$names = explode( '/', $name );

	$parent_id   = null;
	$category_id = null;

	foreach ( $names as $category_name ) {
		$category = Category::firstOrNew(
			array(
				'name'      => $category_name,
				'post_type' => $post_type,
				'parent'    => $parent_id,
			)
		);

		if ( ! $category->exists ) {
			$category->slug = str_slug( $category_name );

			if ( $post_type ) {
				$category->post_type = $post_type;
			}

			$category->save();
		}

		$category_id = $category->id;

		$parent_id = $category_id;
	}

	return $category_id;
}

/**
 * Get categories by type.
 *
 * @param string $type The category type.
 * @return mixed
 */
function get_categories( $type ) {
	$categories = Category::with( 'children' )->where( 'post_type', $type )->get();

	return $categories;
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

	if ( empty( $args['item_args'] ) ) {
		$args['item_args'] = array(
			'class' => 'half',
		);
	}

	switch ( $menu ) {

		// Main menu.
		case 'main':
			$primary_menu_items = App\Menu::all()->toArray();
			if ( ! count( $primary_menu_items ) ) {
				$primary_menu_items = array();
			}

			$primary_menu_items = array_merge(
				array(
					array(
						'url'     => 'admin',
						'name'    => __( 'Dashboard' ),
						'options' => array(
							'icon' => 'fas fa-bars',
						),
					),
				),
				$primary_menu_items
			);

			if ( Auth::check() ) {
				$primary_menu_items = array_merge(
					$primary_menu_items,
					array(
						array(
							'url'     => 'logout',
							'name'    => __( 'Log Out' ),
							'options' => array(
								'icon' => 'fas fa-sign-out-alt',
							),
						),
					)
				);
			}

			foreach ( $primary_menu_items as $_item ) {
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
			$categories = get_categories( $args['post_type']['id'] );

			if ( $categories ) {
				$items[] = array_merge(
					[
						'name' => __( 'All' ),
						'url'  => str_plural( $args['post_type']['slug'] ),
					],
					$args['item_args']
				);

				if ( \Request::is( str_plural( $args['post_type']['slug'] ) ) ) {
					$items[0]['class'] = ( isset( $items[0]['class'] ) ) ? $items[0]['class'] . ' active' : 'active';
				}

				foreach ( $categories as $category ) {
					if ( $category->parent ) {
						continue;
					}

					$item_args = $args['item_args'];

					$item_url = str_plural( $args['post_type']['slug'] ) . '/category/' . $category->slug;

					if ( \Request::is( [ $item_url, "$item_url/*" ] ) || ( ! empty( $args['current'] ) && $args['current'] === $category->id ) ) {
						$item_args['class'] .= ' active';
					}

					$items[] = array_merge(
						[
							'name' => $category->name,
							'url'  => $item_url,
						],
						$item_args
					);

					foreach ( $category->descendants() as $category ) {
						$item_args = $args['item_args'];

						$item_args['class'] .= ' subcategory';

						$item_url = str_plural( $args['post_type']['slug'] ) . '/category/' . $category->slug;

						if ( \Request::is( [ $item_url, "$item_url/*" ] ) || ( ! empty( $args['current'] ) && $args['current'] === $category->id ) ) {
							$item_args['class'] .= ' active';
						}

						$items[] = array_merge(
							[
								'name' => $category->name,
								'url'  => $item_url,
							],
							$item_args
						);
					}
				}
			}

			break;

	}

	return $items;
}

/**
 * Return array of post types.
 *
 * @return array
 */
function get_post_types() {
	if ( ! Schema::hasTable('post_types') ) {
		return array();
	}

	return PostType::all()->toArray();
}
