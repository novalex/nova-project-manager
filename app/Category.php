<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $guarded = [];

	/**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName() {
		return 'slug';
	}

	/**
	 * Auto-generate slug attribute from name attribute.
	 *
	 * @param string $value The name attribute value.
	 * @return void
	 */
	public function setNameAttribute( $value ) {
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = str_slug( $value );
	}

	/**
	 * Get posts by category ID.
	 *
	 * @param int $category_id The ID of the category.
	 * @return array
	 */
	public function posts( $category_id ) {
		return Post::where( 'category', $category_id )->get();
	}
}
