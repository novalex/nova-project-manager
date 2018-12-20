// jshint esversion: 6

// Helpers.
const { triggerEvent } = require( './inc/helpers' );

window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// UI.
require( './ui/forms' );
require( './ui/actions' );
require( './ui/editor' );
require( './ui/navigation' );

// Vue
window.Vue = require( 'vue' );
Vue.config.ignoredElements = ['IfModule'];

// Load directives.
var directives = require.context( './directives', true, /^(.*\.(js$))[^.]*$/i );
directives.keys().forEach( directives );

// Load components.
Vue.component( 'editor', require( './components/Editor.vue' ) );

window.initApp = function() {
	const appDataContainer = document.getElementById( 'app-data' );

	let appData = {};

	if ( appDataContainer ) {
		appData = JSON.parse( appDataContainer.innerHTML );
	}

	new Vue( {
		el: '#app',

		data: {
			navTopTitle: appData.navTopTitle || '',
			navTopSubtitle: appData.navTopSubtitle || '',
		}
	});

	triggerEvent( document, 'app.ready' );
}

initApp();

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
