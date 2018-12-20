<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model {

	protected $guarded = [];

	protected $appends = [
		'url',
	];

	public $timestamps = false;

	public function getRouteKeyName() {
		return 'url';
	}

	public function setNameAttribute( $value ) {
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = str_slug( $value );
	}

	public function getUrlAttribute() {
		return str_plural( $this->slug );
	}
}
