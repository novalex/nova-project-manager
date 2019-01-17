<?php

namespace App\Http\Controllers;

use App\PostType;
use Illuminate\Http\Request;

class SearchController extends Controller {

	/**
	 * The search query.
	 *
	 * @var string
	 */
	public $query;

	/**
	 * Array of search query words.
	 *
	 * @var array
	 */
	public $words;

	/**
	 * Perform search query.
	 *
	 * @param string $query The query to search for.
	 * @param int    $limit The maximum number of results to fetch.
	 * @return \Illuminate\Http\Response
	 */
	public function search( string $query, int $limit = 10 ) {
		$this->query = trim( $query );
		$this->words = explode( ' ', $this->query );
		usort( $this->words, function( $a, $b ) {
			return strlen( $b ) - strlen( $a );
		} );

		$results = array();

		// Get posts.
		foreach ( \Search::posts( 'name', 'slug', 'body' )->query( $query )->getQuery()->limit( $limit )->get() as $result ) {
			$post_type = PostType::where( 'id', $result->post_type )->first();

			$results[] = array(
				'name' => $this->formatResultName( $result->name ),
				'body' => $this->formatResultBody( $result->body ),
				'type' => empty( $post_type ) ? __( 'Post' ) : $post_type->name,
				'link' => url( ( empty( $post_type ) ? 'posts' : $post_type->url ) . '/' . $result->slug ),
			);
		}

		// Get post types.
		foreach ( PostType::hydrate( \Search::post_types( 'name', 'slug' )->query( $query )->getQuery()->limit( $limit )->get()->toArray() ) as $result ) {
			$results[] = array(
				'name' => $this->formatResultName( $result->name ),
				'type' => __( 'Post Type' ),
				'link' => url( $result->url ),
			);
		}

		// Get categories.
		foreach ( \Search::categories( 'name', 'slug' )->query( $query )->getQuery()->limit( $limit )->get() as $result ) {
			$post_type = PostType::where( 'id', $result->post_type )->first();

			$results[] = array(
				'name' => $this->formatResultName( $result->name ),
				'type' => empty( $post_type ) ? __( 'Category' ) : sprintf( __( '%s Category' ), $post_type->name ),
				'link' => url( ( empty( $post_type ) ? 'posts' : $post_type->url ) . '/category/' . $result->slug ),
			);
		}

		// Render results.
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
	function formatResultName( $name, $limit = 55 ) {
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
	function formatResultBody( $body, $limit = 70 ) {
		if ( empty( $body ) ) {
			return '';
		}

		$body = strip_tags( ( new \Parsedown() )->text( $body ) );

		$padding_chars = ( $limit - strlen( $this->query ) / 2 ) / 2;

		$start_at = 0;
		$end_at   = strlen( $body );

		foreach ( $this->words as $word ) {
			$word_start_at = stripos( $body, $word );

			if ( false === $word_start_at ) {
				continue;
			}

			$start_at = max( $start_at, $word_start_at - $padding_chars );
			$end_at   = min( $end_at, $word_start_at + strlen( $word ) );
		}

		$body = substr( $body, $start_at, $padding_chars * 2 + $end_at - $start_at );

		if ( $start_at > 0 && strlen( $body ) > 0 ) {
			$body = '&hellip;' . $body;
		}

		$body = str_limit( $body, $limit );

		return $this->formatResultMatches( $body );
	}

	/**
	 * Highlight the search query matches in given string.
	 *
	 * @param string $text String in which to highlight matches.
	 * @return string
	 */
	function formatResultMatches( $text ) {
		foreach ( $this->words as $word ) {
			$text = preg_replace( '/' . preg_quote( $word, '/' ) . '/i', "<em>\$0</em>", $text );
		}

		return $text;
	}

}
