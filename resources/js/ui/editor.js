// Plugins.
const hljs = require( '../plugins/highlight' );
const SimpleMDE = require( '../plugins/simplemde' );

document.addEventListener( 'app.ready', function() {

	// Markdown editor.
	const editor = document.getElementById( 'body' );

	if ( editor ) {
		new SimpleMDE({
			element: editor,
			spellChecker: false,
			renderingConfig: {
				codeSyntaxHighlighting: true,
			},
		});
	}

	// Code formatting.
	$('pre code').each( function( i, block ) {
		hljs.highlightBlock( block );
	});
} );
