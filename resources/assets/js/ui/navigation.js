// Barba.js PJAX.
Barba = require( 'barba.js' );

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
	this.oldContainer.remove();

	initApp();

	this.newContainer.style.visibility = 'visible';
	this.deferred.resolve();
};

Barba.Pjax.Dom.wrapperId = 'app';
Barba.Pjax.Dom.containerClass = 'app-container';
Barba.Pjax.start();
Barba.Prefetch.init();

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
