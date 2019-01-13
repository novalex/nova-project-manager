<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostType;
use App\Category;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller {

	/**
	 * The search keyword.
	 *
	 * @var string
	 */
	public $keyword;

	/**
	 * Perform search query.
	 *
	 * @param string $keyword The keyword to search for.
	 * @return \Illuminate\Http\Response
	 */
	public function search( string $keyword ) {
		$this->keyword = $keyword;

		$results = array();

		// Get posts.
		$posts = Post::where( 'name', 'like', "%$keyword%" )
			->orWhere( 'slug', 'like', "%$keyword%" )
			->orWhere( 'body', 'like', "%$keyword%" )
			->get();

		foreach ( $posts as $result ) {
			$post_type = PostType::where( 'id', $result->post_type )->first();

			$results[] = array(
				'name' => $this->formatResultName( $result->name ),
				'body' => $this->formatResultBody( $result->body ),
				'type' => empty( $post_type ) ? __( 'Post' ) : $post_type->name,
			);
		}

		// Get post types.
		$post_types = PostType::where( 'name', 'like', "%$keyword%" )
			->orWhere( 'slug', 'like', "%$keyword%" )
			->get();

		// Get categories.
		$categories = Category::where( 'name', 'like', "%$keyword%" )
			->orWhere( 'slug', 'like', "%$keyword%" )
			->get();

		$data = array(
			'html' => \View::make(
				'partials.search-results',
				array(
					'results' => $results,
				)
			)->render(),
		);

		return response()->json( $data, 200 );
	}

	/**
	 * Format the name for a search result.
	 *
	 * @param string $name  Name string to format.
	 * @param int    $limit Character limit.
	 * @return string
	 */
	function formatResultName( $name, $limit = 60 ) {
		if ( empty( $name ) ) {
			return '';
		}

		$name = str_limit( $name, $limit );

		return $this->formatResultMatches( $name );
	}

	/**
	 * Format the body for a search result.
	 *
	 * @param string $body  Body string to format.
	 * @param int    $limit Character limit.
	 * @return string
	 */
	function formatResultBody( $body, $limit = 90 ) {
		if ( empty( $body ) || strpos( $body, $this->keyword ) === false ) {
			return '';
		}

		$body = strip_tags( ( new \Parsedown() )->text( $body ) );

		$padding_chars = ( $limit - strlen( $this->keyword ) / 2 ) / 2;

		$start_at = max( 0, strpos( $body, $this->keyword ) - $padding_chars );

		$end_at = min( strlen( $body ), $padding_chars + strlen( $this->keyword ) + $padding_chars );

		$body = substr( $body, $start_at, $end_at );

		if ( $start_at > 0 ) {
			$body = '&hellip;' . $body;
		}

		$body = str_limit( $body, $limit );

		return $this->formatResultMatches( $body );
	}

	/**
	 * Highlight the search keyword matches in given string.
	 *
	 * @param string $text String in which to highlight matches.
	 * @return string
	 */
	function formatResultMatches( $text ) {
		return preg_replace( '/' . preg_quote( $this->keyword, '/' ) . '/i', "<em>\$0</em>", $text );
	}

}
