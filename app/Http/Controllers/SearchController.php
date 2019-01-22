<?php

namespace App\Http\Controllers;

use App\PostType;
use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

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
	 * Maximum number of results to fetch.
	 *
	 * @var int
	 */
	public $limit = 30;

	/**
	 * Whether the current search is a quick search.
	 *
	 * @var bool
	 */
	public $quicksearch = false;

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! empty( request()->input( 'query' ) ) ) {
			$this->query = trim( request()->input( 'query' ) );

			$this->words = explode( ' ', $this->query );

			usort( $this->words, function( $a, $b ) {
				return strlen( $b ) - strlen( $a );
			} );
		}

		if ( ! empty( request()->input( 'limit' ) ) ) {
			$this->limit = intval( request()->input( 'limit' ) );
		}
	}

	/**
	 * Display search page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data = array(
			'title' => __( 'Search' ),
		);

		if ( ! empty( $this->query ) ) {
			// A search has been performed, show results.
			if ( ! empty( request()->input( 'json' ) ) ) {
				// Send back JSON.
				return $this->getResultsJSON();
			}

			$data['title']   = sprintf( __( 'Search results for "%s"' ), $this->query );
			$data['results'] = $this->search();
		}

		return view( 'pages.search', $data );
	}

	/**
	 * Perform search and return results as array.
	 *
	 * @param int $offset The offset amount.
	 * @return array
	 */
	public function search( int $offset = 0 ) {
		if ( empty( $this->query ) ) {
			return array();
		}

		$results = array();

		// Get posts.
		$posts = \Search::posts( 'name', 'slug', 'body' )->query( $this->query )->getQuery()->simplePaginate( $this->limit );
		foreach ( $posts as $result ) {
			$post_type = PostType::where( 'id', $result->post_type )->first();

			$group = empty( $post_type ) ? __( 'Posts' ) : str_plural( $post_type->name );

			$results['items'][ $group ][] = array(
				'name' => $this->formatResultName( $result->name ),
				'body' => $this->formatResultBody( $result->body ),
				'link' => url( ( empty( $post_type ) ? 'posts' : $post_type->url ) . '/' . $result->slug ),
			);
		}
		// Add pagination information.
		if ( $this->quicksearch ) {
			$results['links'] = new HtmlString( '<li class="all-results"><a href="' . url( 'search?query=' . request()->input( 'query' ) ) . '"><strong>' . __( 'View All Results' ) . '</strong></a></li>' );
		} elseif ( $posts->hasMorePages() ) {
			$results['links'] = $posts->withPath( '?query=' . $this->query )->links();
		} else {
			$results['links'] = '';
		}

		// If this is a paged query, only return posts.
		if ( $posts->currentPage() > 1 ) {
			return $results;
		}

		// Get categories.
		$categories = \Search::categories( 'name', 'slug' )->query( $this->query )->getQuery()->limit( $this->limit )->offset( $offset )->get();
		foreach ( $categories as $result ) {
			$post_type = PostType::where( 'id', $result->post_type )->first();

			$group = empty( $post_type ) ? __( 'Categories' ) : sprintf( __( '%s Categories' ), $post_type->name );

			$results['items'][ $group ][] = array(
				'name' => $this->formatResultName( $result->name ),
				'link' => url( ( empty( $post_type ) ? 'posts' : $post_type->url ) . '/category/' . $result->slug ),
			);
		}

		// Get post types.
		$post_types = PostType::hydrate( \Search::post_types( 'name', 'slug' )->query( $this->query )->getQuery()->limit( $this->limit )->offset( $offset )->get()->toArray() );
		foreach ( $post_types as $result ) {
			$group = __( 'Post Types' );

			$results['items'][ $group ][] = array(
				'name' => $this->formatResultName( $result->name ),
				'link' => url( $result->url ),
			);
		}

		return $results;
	}

	/**
	 * Perform search and return results as JSON.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getResultsJSON() {
		$this->quicksearch = true;

		// Render results.
		$data = array(
			'html' => \View::make(
				'partials.search-results',
				array(
					'results' => $this->search(),
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
