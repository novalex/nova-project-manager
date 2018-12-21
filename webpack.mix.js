let mix = require( 'laravel-mix' );

mix.disableNotifications();

mix.js( 'resources/js/app.js', 'public/js' );

mix.sass( 'resources/sass/app.scss', 'public/css' );

mix.browserSync( {
	open: false,
	proxy: 'npm.nov',
	snippetOptions: {
		whitelist: [ '/**' ],
	}
} );