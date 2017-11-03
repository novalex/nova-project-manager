$( document ).ready( function() {

	$('pre code').each( function( i, block ) {
		hljs.highlightBlock( block );
	});

	if ( typeof MediumEditor !== 'undefined' ) {
		var editor = new MediumEditor( '.editable', {
			toolbar: {
				allowMultiParagraphSelection: true,
				buttons: [
					'bold',
					'italic',
					'underline',
					'anchor',
					'h1',
					'h2',
					'h3',
					'quote',
					'justifyLeft',
					'justifyCenter',
					'justifyRight',
					'code'
				],
				diffLeft: 0,
				diffTop: -10,
				firstButtonClass: 'medium-editor-button-first',
				lastButtonClass: 'medium-editor-button-last',
				relativeContainer: null,
				standardizeSelectionStart: false,
				static: false,
			},

			paste: {
				forcePlainText: true,
				cleanPastedHTML: true,
			},

			extensions: {
				'code': new MediumButton({
					label: 'Code',
					start: '<pre><code>',
					end: '</code></pre>',
					action: function( html, mark, parent ) {
						if ( mark ) {
							var lang = prompt( 'Language:' );
							if ( lang ) {
								return '<!--'+html+'-->' + 
									html.replace(/<pre><code>/g, '')
										.replace(/<\/pre><\/code>/g, '')
										.replace(/<\/div><div>/g, "\n")
										.replace(/<\/p><p>/g, "\n")
										.replace(/</g, "<")
										.replace(/>/g, ">");
							}
						}
						return html.split('-->')[0].split('<!--').join('');
					}
				})
			}
		} );

		$('.medium-editor-element pre code').each( function( i, block ) {
			hljs.highlightBlock( block );
		});
	}
} );
