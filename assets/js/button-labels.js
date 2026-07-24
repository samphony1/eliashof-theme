( function () {
	'use strict';

	const selector = '.wp-element-button, .wp-block-button__link, .eliashof-aktuelles-carousel .wp-block-read-more, .spb-filter-btn, .eliashof-post-navigation a, .eliashof-spb-werte-card__label';

	function wrapLabel( button ) {
		const existingLabel = button.querySelector( ':scope > .eliashof-button-label' );
		if ( existingLabel ) {
			if ( ! existingLabel.querySelector( ':scope > .eliashof-button-label-text' ) ) {
				const text = document.createElement( 'span' );
				text.className = 'eliashof-button-label-text';
				while ( existingLabel.firstChild ) {
					text.appendChild( existingLabel.firstChild );
				}
				existingLabel.appendChild( text );
			}
			return;
		}

		Array.from( button.childNodes ).forEach( function ( node ) {
			if ( node.nodeType !== Node.TEXT_NODE || ! node.textContent.trim() ) {
				return;
			}

			const label = document.createElement( 'span' );
			const text = document.createElement( 'span' );
			label.className = 'eliashof-button-label';
			text.className = 'eliashof-button-label-text';
			button.replaceChild( label, node );
			label.appendChild( text );
			text.appendChild( node );
		} );
	}

	function init( root ) {
		if ( root.nodeType === Node.ELEMENT_NODE && root.matches( selector ) ) {
			wrapLabel( root );
		}

		if ( root.querySelectorAll ) {
			root.querySelectorAll( selector ).forEach( wrapLabel );
		}
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		init( document );

		new MutationObserver( function ( mutations ) {
			mutations.forEach( function ( mutation ) {
				mutation.addedNodes.forEach( init );
			} );
		} ).observe( document.body, { childList: true, subtree: true } );
	} );
}() );
