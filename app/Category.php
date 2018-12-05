<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $guarded = [];

	public function getRouteKeyName() {
		return 'slug';
	}

	public function setNameAttribute( $value ) {
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = str_slug( $value );
	}

	public function projects( $category_id ) {
		return Project::where( 'category_id', $category_id )->get();
	}

	public function snippets( $category_id ) {
		return Snippet::where( 'category_id', $category_id )->get();
	}

	public function posts( $category_id ) {
		$projects = Project::where( 'category_id', $category_id )->get();
		$snippets = Snippet::where( 'category_id', $category_id )->get();
		return $projects->concat( $snippets );
	}
}
