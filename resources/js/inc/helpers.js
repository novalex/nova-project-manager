
/**
 * Dispatch an event.
 *
 * @param {object} el - The object for which to dispatch event.
 * @param {string} type - The type of event.
 */
function triggerEvent( el, type ) {
	if ( 'createEvent' in document ) {
		// modern browsers, IE9+
		var e = document.createEvent( 'HTMLEvents' );
		e.initEvent( type, false, true );
		el.dispatchEvent( e );
	} else {
		// IE 8
		var e = document.createEventObject();
		e.eventType = type;
		el.fireEvent( 'on' + e.eventType, e );
	}
}

module.exports = {
	triggerEvent
};
