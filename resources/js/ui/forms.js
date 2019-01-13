
document.addEventListener( 'app.ready', function() {

	// Input filters.
	$('.filter-slug').on( 'change blur', function( e ) {
		var el = $(this)[0];

		el.value = el.value.toLowerCase()
			.replace(/[^\w\s-]/g, '')
			.replace(/[\s_-]+/g, '-')
			.replace(/^-+|-+$/g, '');
	});

	// Search.
	let $searchWrap = $( '#nav-top-search' );
	let $searchField = $( 'input', $searchWrap );
	let $searchResultsHolder = $( '.search-results-holder', $searchWrap );
	let debouncedSearch = _.debounce( doSearch, 250 );

	function doSearch() {
		let value = $searchField.val();

		console.log( value.length );

		if ( value.length < 3 ) {
			$searchResultsHolder.html( '' );

			return;
		}

		fetch( '/search/' + value )
			.then( function( response ) {
				console.log( response );
				return response.json();
			} )
			.then( function( json ) {
				if ( json.html ) {
					$searchResultsHolder.html( json.html );
				}
			} );
	}

	$searchField.on( 'keyup', debouncedSearch );
});
