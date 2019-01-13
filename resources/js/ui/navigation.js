
// Barba.js PJAX.
const Barba = require( 'barba.js' );

const FadeTransition = Barba.BaseTransition.extend( {
	start: function() {
		Promise
			.all( [ this.newContainerLoading ] )
			.then( this.fadeInOut.bind( this ) );
	},

	fadeInOut: function() {
		var _this = this;
		var $oldContent = $( _this.oldContainer );
		var $newContent = $( _this.newContainer );

		$oldContent.addClass( 'fading-out' );
		$newContent.addClass( 'fading-in' ).css( 'visibility', '' );

		if ( _this.oldContainer.childElementCount === _this.newContainer.childElementCount ) {
			$oldContent.addClass( 'fade-layout' );
		} else {
			$oldContent.addClass( 'switch-layout' );
		}

		$oldContent.one( 'webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
			_this.oldContainer.remove();

			$newContent.removeClass( 'fading-in' );

			_this.done();
		} );
	}
} );

Barba.Pjax.getTransition = function() {
	return FadeTransition;
};

Barba.BaseTransition.done = function() {
	initApp();

	this.deferred.resolve();
};

Barba.Pjax.Dom.wrapperId = 'app';
Barba.Pjax.Dom.containerClass = 'app-container';
// Barba.Pjax.start();
// Barba.Prefetch.init();

// Menu navigation.
const navigation = document.querySelector( '#nav-main-menu' );
if ( navigation ) {
	let menuItems = navigation.querySelectorAll( '.menu-item' );

	menuItems.forEach( function( item ) {
		item.addEventListener( 'click', function() {
			menuItems.forEach( function( itemi ) {
				itemi.classList.remove( 'active' );
			} );

			item.classList.add( 'active' );
		} );
	} );
}
