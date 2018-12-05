// jshint esversion: 6

//
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

		$el.animate( { opacity: 1 }, 100, function() {
			_this.done();
		} );
	}
} );

Barba.Pjax.getTransition = function() {
	return FadeTransition;
};

Barba.BaseTransition.done = function() {
	this.oldContainer.parentNode.removeChild(this.oldContainer);
	this.newContainer.style.visibility = 'visible';
	this.deferred.resolve();

	initVueApp();
};

Barba.Pjax.Dom.containerClass = 'app-container';
Barba.Pjax.Dom.wrapperId = 'app';
// Barba.Pjax.start();
// Barba.Prefetch.init();

// Menu navigation.
var navigation = document.querySelector( '#nav-main-menu' );
menuItems = navigation.querySelectorAll( '.menu-item' );

menuItems.forEach( function( item ) {
	item.addEventListener( 'click', function() {
		menuItems.forEach( function( itemi ) {
			itemi.classList.remove( 'active' );
		} );

		item.classList.add( 'active' );
	} );
});
