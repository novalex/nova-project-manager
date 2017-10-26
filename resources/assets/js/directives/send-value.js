
Vue.directive( 'send-value', {
	params: [ 'sendValueClass' ],

	bind( el, binding, vnode ) {
		console.log('.' + vnode.data.attrs['send-value-class']);
		var bindTo = $( '.' + vnode.data.attrs['send-value-class'] );

		this.bindTo = ( bindTo.length ) ? bindTo : false;
	},

	update( el ) {
		console.log(this.bindTo);
		if ( this.bindTo ) {
			this.bindTo[0].value = el.value;
		}
	}
});
