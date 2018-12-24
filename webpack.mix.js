let mix = require( 'laravel-mix' );

mix.disableNotifications();

mix.js( 'resources/js/app.js', 'public/js' );

mix.sass( 'resources/sass/app.scss', 'public/css' ).options( {
	processCssUrls: false
} );

mix.browserSync( {
	open: false,
	notify: false,
	proxy: 'npm.nov',
} );