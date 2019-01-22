document.addEventListener( 'app.ready', function() {

	// Input filters.
	$( '.filter-slug' ).on( 'change blur', function( e ) {
		var el = $( this )[ 0 ];

		el.value = el.value.toLowerCase()
			.replace( /[^\w\s-]/g, '' )
			.replace( /[\s_-]+/g, '-' )
			.replace( /^-+|-+$/g, '' );
	} );

	// Field clear.
	$( '.field-clear' ).each( function() {
		let $fieldWrap = $( this );
		let $button = $( 'button.clear', $fieldWrap );
		let $field = $( 'input', $fieldWrap );

		$field.toggleClass( 'dirty', $field.val().length > 0 );

		$field.on( 'keyup change', function( e ) {
			$field.toggleClass( 'dirty', $field.val().length > 0 );
		} );

		$button.on( 'click', function( e ) {
			e.preventDefault();

			$field.val( '' ).trigger( 'change' );
		} );
	} );

	// Search.
	let $searchWrap = $( '#nav-top-search' );
	let $searchField = $( 'input', $searchWrap );
	let $searchResultsHolder = $( '.search-results-holder', $searchWrap );

	let searchController;
	let searchQuery;

	function cancelSearch() {
		$searchField.removeClass( 'loading' );

		if ( searchController ) {
			// Abort any previous searches.
			searchController.abort();
		}
	};

	function doSearch() {
		let value = $searchField.val().trim();

		if ( searchQuery === value ) {
			// Search value didn't change, bail.
			return;
		}

		// Cancel previous search.
		cancelSearch();

		// Clear the results.
		$searchResultsHolder.empty();

		if ( value.length < 3 ) {
			// Query is too short, bail.
			searchQuery = value;

			return;
		}

		// Loading state.
		$searchField.addClass( 'loading' );

		searchController = new AbortController();

		// Fetch results.
		fetch( '/search?query=' + value + '&json=1&limit=5', {
			signal: searchController.signal
		} )
			.then( function( response ) {
				searchQuery = value;

				$searchField.removeClass( 'loading' );

				$searchResultsHolder.addClass( 'show' );

				return response.json();
			} )
			.then( function( json ) {
				if ( json.html ) {
					$searchResultsHolder.html( json.html );
				}
			} )
			.catch( function( err ) {
				if ( err.name === 'AbortError' ) {
					console.log( 'Search cancelled' );
				} else {
					console.error( 'Search error!', err );
				}
			} );
	}

	let doDebouncedSearch = _.debounce( doSearch, 600, {
		trailing: true
	} );

	$searchField.on( 'keyup', function( e ) {
		if ( ! e || ! e.key ) {
			return;
		}

		switch ( e.key ) {
			case 'Escape':
				// Escape was pressed, cancel ongoing searches and hide results.
				cancelSearch();

				$searchResultsHolder.removeClass( 'show' );

				return;

				break;
			case 'Enter':
				// Enter was pressed, show results if already loaded.
				$searchResultsHolder.addClass( 'show' );

				break;

			default:
				doDebouncedSearch();

				break;

		}
	} );

	$searchField.on( 'change ', doSearch );

	// Hide search dropdown on blur.
	$( 'body' ).on( 'click', function( e ) {
		let $target = $( e.target );

		$searchResultsHolder.not( $target.parents( $searchResultsHolder ) ).removeClass( 'show' );
	} );

} );
