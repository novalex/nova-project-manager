<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

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
}
