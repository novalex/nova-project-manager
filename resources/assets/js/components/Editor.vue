<template>
	<div class="editor-wrap">
		<textarea :id="elId" :name="name" :rows="rows" v-html="content"></textarea>

		<div class="rendered-markdown" v-html="rendered"></div>
	</div>
</template>

<script>
	const { Markdown } = require( '../plugins/markdown-extra' );

	export default {
		props: [ 'elId', 'name', 'rows', 'content' ],

		mounted: function() {
			console.log('Component mounted.');
		},

		data: function() {
			return {
				rendered: Markdown( this.content )
			};
		}
	}
</script>
