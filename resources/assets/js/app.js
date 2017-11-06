// jshint esversion: 6

require( './bootstrap' );

// Plugins
window.hljs = require( './plugins/highlight' );
MediumButton = require( './plugins/medium-button' );
MediumEditor = require( './plugins/medium-editor' );

// UI
require( './ui/forms' );
require( './ui/actions' );
require( './ui/editor' );


// Barba.js PJAX

Barba = require( '../../../node_modules/barba.js/dist/barba.js' );

var FadeTransition = Barba.BaseTransition.extend( {
	start: function() {
		Promise
			.all( [ this.newContainerLoading, this.fadeOut() ] )
			.then( this.fadeIn.bind( this ) );
	},

	fadeOut: function() {
		return $( this.oldContainer ).animate( { opacity: 0 } ).promise();
	},

	fadeIn: function() {
		var _this = this;
		var $el = $( this.newContainer );

		$( this.oldContainer ).hide();

		$el.css( {
			visibility: 'visible',
			opacity: 0
		} );

		$el.animate( { opacity: 1 }, 400, function() {
			_this.done();
		} );
	}
} );

// Barba.Pjax.getTransition = function() {
// 	return FadeTransition;
// };

Barba.Pjax.Dom.containerClass = 'app-container';
Barba.Pjax.Dom.wrapperId = 'app';
// Barba.Pjax.start();
// Barba.Prefetch.init();

var navigation = document.querySelector( '#nav-main-menu' );
menuItems = navigation.querySelectorAll( '.menu-item' );

menuItems.forEach( function( item ) {
	item.addEventListener( 'click', function() {
		menuItems.forEach( function( itemi ) {
			itemi.classList.remove( 'active' );
		} );

		item.classList.add( 'active' );
	} );
} );


// Vue

window.Vue = require( 'vue' );

Vue.config.ignoredElements = ['IfModule'];

// Load directives.
var directives = require.context( './directives', true, /^(.*\.(js$))[^.]*$/i );
directives.keys().forEach( directives );

// Load components.
Vue.component( 'example', require( './components/Example.vue' ) );

const app = new Vue( {
	el: '#app',

	data: {
		navTopTitle: window.defaultData.navTopTitle || '',
		navTopSubtitle: window.defaultData.navTopSubtitle || '',
	}
} );
