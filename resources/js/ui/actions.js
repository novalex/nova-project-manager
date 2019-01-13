
document.addEventListener( 'app.ready', function() {

	// Delete
	$('.action-delete').on('click', function( e ) {
		if ( ! confirm( 'Are you sure you want to delete this?' ) ) {
			e.preventDefault();
		}
	});
});
