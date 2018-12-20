<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	protected $guarded = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'options' => 'array',
	];

	public $timestamps = false;

}
