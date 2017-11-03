$(document).ready( function() {

	// Delete
	$('.action-delete').on('click', function( e ) {
		var sure = confirm( 'Are you sure you want to delete this?' );

		if ( ! sure ) e.preventDefault();
	});
});
