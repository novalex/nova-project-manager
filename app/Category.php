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
	 * Set the name attribute and generate a slug.
	 *
	 * @param string $value The name attribute value.
	 * @return void
	 */
	public function setNameAttribute( $value ) {
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = $this->setSlugAttribute( $value );
	}

	/**
	 * Auto-generate slug attribute from name attribute.
	 *
	 * @param string $value The name attribute value.
	 * @return void
	 */
	public function setSlugAttribute( $value ) {
		$slug = str_slug( $value );

		if ( $this->whereSlug( $slug )->exists() ) {
			$orig_slug = $slug;

			$count = 1;

			while ( $this->whereSlug( $slug )->exists() ) {
				$slug = $orig_slug . $count++;
			}
		}

		$this->attributes['slug'] = $slug;
	}

	/**
	 * Get posts by category ID.
	 *
	 * @param int $category_id The ID of the category.
	 * @return array
	 */
	public function getPosts( $category_id ) {
		return Post::where( 'category', $category_id )->get();
	}

	/**
	 * Get posts belonging to category.
	 *
	 * @return array
	 */
	public function posts() {
		return $this->hasMany( 'App\Post', 'category' );
	}

	/**
	 * Get parent category.
	 *
	 * @return mixed
	 */
	public function parent() {
		return $this->belongsTo( 'App\Category', 'parent' );
	}

	/**
	 * Get child categories.
	 *
	 * @return mixed
	 */
	public function children() {
		return $this->hasMany( 'App\Category', 'parent' );
	}

	/**
	 * Get descendant categories recursively.
	 *
	 * @return mixed
	 */
	public function descendants() {
		$categories = collect( array() );

		$children = $this->children()->with( 'posts' )->get();

		while ( $children->isNotEmpty() ) {
			$children_ids = array();

			foreach ( $children as $child ) {
				$categories->push( $child );

				$children_ids[] = $child->id;
			}

			$children = Category::whereIn( 'parent', $children_ids )->with( 'posts' )->get();
		}

		return $categories;
	}
}
