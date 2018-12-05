
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

// Vue
window.Vue = require( 'vue' );
Vue.config.ignoredElements = ['IfModule'];

// Load directives.
var directives = require.context( './directives', true, /^(.*\.(js$))[^.]*$/i );
directives.keys().forEach( directives );

// Load components.
Vue.component( 'editor', require( './components/Editor.vue' ) );

const app = new Vue( {
	el: '#app',

	data: {
		navTopTitle: window.defaultData.navTopTitle || '',
		navTopSubtitle: window.defaultData.navTopSubtitle || '',
	}
});

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
