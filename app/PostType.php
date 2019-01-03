<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model {

	protected $guarded = [];

	public $timestamps = false;

	protected $appends = [
		'url',
	];

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
	 * Auto-generate URL attribute on the fly by converting the slug to a plural string.
	 *
	 * @return string
	 */
	public function getUrlAttribute() {
		return str_plural( $this->slug );
	}
}
