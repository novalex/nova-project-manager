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
require( './ui/ui' );
require( './ui/forms' );
require( './ui/actions' );
require( './ui/editor' );
require( './ui/navigation' );

// Init.
window.initApp = function() {
	triggerEvent( document, 'app.ready' );
}

initApp();
