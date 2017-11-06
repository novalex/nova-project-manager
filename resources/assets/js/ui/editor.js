$( document ).ready( function() {

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
					start: '<small class="code-delimiter">code</small>',
					end: '<small class="code-delimiter">/code</small>',
					action: function( html, mark, parent ) {
						if ( mark ) {
							return '<!--'+html+'--><pre class="hljs-wrap"><code class="hljs">' + 
								html.replace(/<pre class="hljs-wrap"><code class="hljs">/g, '')
									.replace(/<\/pre><\/code>/g, '')
									.replace(/<\/div><div>/g, "\n")
									.replace(/<\/p><p>/g, "\n")
									.replace(/</g, "<")
									.replace(/>/g, ">") + '</code></pre>';
						}
						return html.split('-->')[0].split('<!--').join('');
					}
				})
			}
		} );

		editor.subscribe( 'editableBlur', function( data, editable ) {
			$('pre code', editable).each( function( i, block ) {
				hljs.highlightBlock( block );
			});
		});
	}

	$('pre code').each( function( i, block ) {
		hljs.highlightBlock( block );
	});
} );
