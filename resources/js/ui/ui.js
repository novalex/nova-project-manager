document.addEventListener( 'app.ready', function() {

	// Hide elements on blur.
	$( 'body' ).on( 'click', function( e ) {
		let $target = $( e.target );

		$( '.hide-on-blur' ).not( $target.parents( '.hide-on-blur' ) ).hide();
	} );

} );
