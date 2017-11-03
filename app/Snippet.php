<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model {
	
    protected $guarded = [];

    public function getRouteKeyName() {
    	return 'slug';
    }

    public function setNameAttribute( $value ) {
    	$this->attributes['name'] = $value;
    	$this->attributes['slug'] = str_slug( $value );
    }
}
