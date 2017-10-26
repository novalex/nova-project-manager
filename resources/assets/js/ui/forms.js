$(document).ready( function() {

	// Input filters.
	$('.filter-slug').on( 'change blur', function( e ) {
		var el = $(this)[0];

		el.value = el.value.toLowerCase()
			.replace(/[^\w\s-]/g, '')
			.replace(/[\s_-]+/g, '-')
			.replace(/^-+|-+$/g, '');
	});
});