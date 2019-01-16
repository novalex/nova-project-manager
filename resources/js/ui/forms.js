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

			$field.val( '' ).trigger( 'keyup' );
		} );
	} );

	// Search.
	let $searchWrap = $( '#nav-top-search' );
	let $searchField = $( 'input', $searchWrap );
	let $searchResultsHolder = $( '.search-results-holder', $searchWrap );

	let searchController;
	let searchQuery;

	function doSearch( e = null ) {
		let value = $searchField.val().trim();

		if ( searchQuery === value ) {
			return;
		}

		if ( searchController ) {
			// Abort any previous searches.
			searchController.abort();
		}

		// Clear the results.
		$searchResultsHolder.empty();

		if ( value.length < 2 || ( e && e.key === 'Escape' ) ) {
			// Keyword is too short, field value is the same or escape was pressed, bail.
			$searchField.removeClass( 'loading' );

			return;
		} else {
			// Loading state.
			$searchField.addClass( 'loading' );
		}

		searchQuery = value;

		searchController = new AbortController();

		fetch( '/search/' + value, {
			signal: searchController.signal
		} )
			.then( function( response ) {
				$searchField.removeClass( 'loading' );

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

	$searchField.on( 'keyup', doSearch );

} );
