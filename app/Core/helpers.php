<?php

function get_category( $id ) {
	$category = DB::table('categories')->where('id', $id)->first();

	return ( isset( $category->name ) ) ? $category->name : '';
}

/**
 * Generate a category by name or return existing category's ID.
 *
 * @param string $name The category name.
 */
function get_category_id( $name, $type = null ) {
	$category = App\Category::firstOrNew([
		'name' => $name,
		'type' => $type, 
	]);

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
	return DB::table('categories')->where('type', $type)->get();
}

function get_categories_menu( $type, $args = [] ) {
	$items = [];

	if ( $categories = get_categories( $type ) ) {
		foreach ( $categories as $category ) {
			$items[] = array_merge( [
				'name'  => $category->name,
				'url'   => str_plural( $type ) . '/category/' . $category->slug
			], $args );
		}
	}

	return $items;
}