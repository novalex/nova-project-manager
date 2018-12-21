<template>
	<div class="editor-wrap">
		<textarea :id="elId" :name="name" :rows="rows" v-html="content" class="md-editable"></textarea>
	</div>
</template>

<script>
	export default {
		props: [ 'elId', 'name', 'rows', 'content' ],
	};
</script>
