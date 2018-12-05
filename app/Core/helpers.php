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
 * @param string $name The category name.
 * @return int The category ID.
 */
function get_category_id( $name, $type = null ) {
	$category = App\Category::firstOrNew(
		[
			'name' => $name,
			'type' => $type,
		]
	);

	if ( $category->exists ) {
		return $category->id;
	} else {
		$category->slug = str_slug( $name );
		if ( $type ) {
			$category->type = $type;
		}
		$category->save();

		return $category->id;
	}
}

/**
 * Get categories by type.
 *
 * @param  string $type
 * @return mixed
 */
function get_categories( $type ) {
	return DB::table( 'categories' )->where( 'type', $type )->get();
}

/**
 * Get categories menu items.
 *
 * @param string $type The category type.
 * @param array  $args Additional args.
 * @return array
 */
function get_categories_menu( $type, $args = [] ) {
	$items = [];

	$categories = get_categories( $type );

	if ( $categories ) {
		foreach ( $categories as $category ) {
			$items[] = array_merge(
				[
					'name' => $category->name,
					'url'  => str_plural( $type ) . '/category/' . $category->slug,
				],
				$args
			);
		}
	}

	return $items;
}
