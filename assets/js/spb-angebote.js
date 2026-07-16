/**
 * SPB Angebote — Filter, Mobile Tabs & Intern-Drawer integration
 *
 * Responsibilities:
 *  - AG/IG filter with aria-pressed state
 *  - Mobile day-tabs with arrow-key navigation (ARIA tablist pattern)
 *  - Opens the existing eliashof-intern-drawer when a card is clicked
 *  - Falls back to a simple alert if the drawer is not present
 *
 * No external dependencies; runs after DOMContentLoaded.
 */
(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		/* ── Scope ─────────────────────────────────────────────────── */
		const sections = document.querySelectorAll( '.section-spb-angebote' );

		sections.forEach( function ( section ) {
			initFilter( section );
			initMobileTabs( section );
			initCards( section );
		} );
	} );

	/* ─────────────────────────────────────────────────────────────────
	   FILTER
	───────────────────────────────────────────────────────────────── */
	function initFilter( section ) {
		const filterBtns = section.querySelectorAll( '.spb-filter-btn' );
		if ( ! filterBtns.length ) return;

		filterBtns.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				const type = btn.dataset.filter || 'all';

				// Update aria states
				filterBtns.forEach( function ( b ) {
					b.setAttribute( 'aria-pressed', 'false' );
				} );
				btn.setAttribute( 'aria-pressed', 'true' );

				// Show / hide cards
				const cards = section.querySelectorAll( '.spb-card' );
				cards.forEach( function ( card ) {
					const match = ( type === 'all' ) || ( card.dataset.type === type );
					card.hidden = ! match;
				} );

				// Update empty-state messages per day column
				const days = section.querySelectorAll( '.spb-day' );
				days.forEach( function ( day ) {
					const visible = day.querySelectorAll( '.spb-card:not([hidden])' );
					const empty   = day.querySelector( '.spb-day-empty' );
					if ( ! empty ) return;

					if ( visible.length === 0 ) {
						empty.textContent = 'Keine Angebote für diesen Filter.';
						empty.classList.add( 'is-visible' );
					} else {
						empty.textContent = '';
						empty.classList.remove( 'is-visible' );
					}
				} );
			} );
		} );
	}

	/* ─────────────────────────────────────────────────────────────────
	   MOBILE TABS
	───────────────────────────────────────────────────────────────── */
	function initMobileTabs( section ) {
		const tabList = section.querySelector( '.spb-mobile-tabs' );
		if ( ! tabList ) return;

		const tabs  = Array.from( tabList.querySelectorAll( '.spb-tab-btn' ) );
		const panels = tabs.map( function ( tab ) {
			return section.querySelector( '#' + tab.getAttribute( 'aria-controls' ) );
		} );

		function activateTab( index ) {
			tabs.forEach( function ( tab, i ) {
				const isActive = ( i === index );
				tab.setAttribute( 'aria-selected', isActive ? 'true' : 'false' );
				tab.tabIndex = isActive ? 0 : -1;
			} );
			panels.forEach( function ( panel, i ) {
				if ( ! panel ) return;
				const isActive = ( i === index );
				panel.classList.toggle( 'is-active-tab', isActive );
				panel.hidden = ! isActive;
			} );
		}

		// Set initial state (first tab active)
		activateTab( 0 );

		tabs.forEach( function ( tab, index ) {
			tab.addEventListener( 'click', function () {
				activateTab( index );
			} );

			// Arrow-key navigation (ARIA Authoring Practices)
			tab.addEventListener( 'keydown', function ( e ) {
				let next = index;
				if ( e.key === 'ArrowRight' ) {
					next = ( index + 1 ) % tabs.length;
				} else if ( e.key === 'ArrowLeft' ) {
					next = ( index - 1 + tabs.length ) % tabs.length;
				} else if ( e.key === 'Home' ) {
					next = 0;
				} else if ( e.key === 'End' ) {
					next = tabs.length - 1;
				} else {
					return; // do not preventDefault for other keys
				}
				e.preventDefault();
				activateTab( next );
				tabs[ next ].focus();
			} );
		} );
	}

	/* ─────────────────────────────────────────────────────────────────
	   CARD CLICK → INTERN DRAWER
	───────────────────────────────────────────────────────────────── */
	function initCards( section ) {
		const cards = section.querySelectorAll( '.spb-card' );

		cards.forEach( function ( card ) {
			card.addEventListener( 'click', function () {
				const postId = parseInt( card.dataset.postId, 10 );

				// If a valid postId is attached and the intern-drawer exists, delegate to it.
				if ( postId && typeof window.eliashofOpenInternDrawer === 'function' ) {
					window.eliashofOpenInternDrawer( postId );
					return;
				}

				// Fallback: open a basic modal with the card's inline data.
				openFallbackOverlay( card );
			} );

			// Keyboard: Space / Enter already fire click on <button>.
			// No extra handling needed.
		} );
	}

	/* ─────────────────────────────────────────────────────────────────
	   FALLBACK OVERLAY (used when intern-drawer is not wired up yet)
	   Shows a simple bottom sheet with the card's title / meta.
	───────────────────────────────────────────────────────────────── */
	var overlayEl     = null;
	var lastFocused   = null;

	function buildOverlay() {
		var el   = document.createElement( 'div' );
		el.id    = 'spb-fallback-overlay';
		el.setAttribute( 'role',        'dialog' );
		el.setAttribute( 'aria-modal',  'true' );
		el.setAttribute( 'aria-labelledby', 'spb-overlay-title' );
		el.hidden = true;

		el.innerHTML = [
			'<div class="spb-overlay__backdrop"></div>',
			'<div class="spb-overlay__sheet">',
			'  <button class="spb-overlay__close" aria-label="Overlay schließen">&#x2715;</button>',
			'  <span id="spb-overlay-badge" class="spb-overlay__badge"></span>',
			'  <h2 id="spb-overlay-title" class="spb-overlay__title"></h2>',
			'  <p class="spb-overlay__meta"></p>',
			'  <p class="spb-overlay__note">',
			'    Vollständige Angaben werden aus dem Redaktionssystem geladen.',
			'  </p>',
			'</div>',
		].join( '\n' );

		document.body.appendChild( el );

		// Close on backdrop click
		el.querySelector( '.spb-overlay__backdrop' ).addEventListener( 'click', closeOverlay );

		// Close on button click
		el.querySelector( '.spb-overlay__close' ).addEventListener( 'click', closeOverlay );

		// Close on Escape
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && ! el.hidden ) {
				closeOverlay();
			}
		} );

		return el;
	}

	function openFallbackOverlay( card ) {
		if ( ! overlayEl ) {
			overlayEl = buildOverlay();
		}

		var type    = card.dataset.type ? card.dataset.type.toUpperCase() : '';
		var title   = card.querySelector( '.spb-card-title' )  ? card.querySelector( '.spb-card-title' ).textContent  : '';
		var meta    = card.querySelector( '.spb-card-meta' )   ? card.querySelector( '.spb-card-meta' ).textContent   : '';

		var badge = overlayEl.querySelector( '.spb-overlay__badge' );
		badge.textContent = type;
		badge.dataset.type = type.toLowerCase();

		overlayEl.querySelector( '.spb-overlay__title' ).textContent = title;
		overlayEl.querySelector( '.spb-overlay__meta' ).textContent  = meta;

		lastFocused   = document.activeElement;
		overlayEl.hidden = false;
		document.body.style.overflow = 'hidden';

		// Focus the close button
		var closeBtn = overlayEl.querySelector( '.spb-overlay__close' );
		if ( closeBtn ) {
			setTimeout( function () { closeBtn.focus(); }, 50 );
		}

		// Register scroll lock with the shared system if available
		if ( typeof window.eliashofSetScrollLock === 'function' ) {
			window.eliashofSetScrollLock( 'spb-overlay', true );
		}
	}

	function closeOverlay() {
		if ( ! overlayEl ) return;
		overlayEl.hidden = true;

		if ( typeof window.eliashofSetScrollLock === 'function' ) {
			window.eliashofSetScrollLock( 'spb-overlay', false );
		} else {
			document.body.style.overflow = '';
		}

		if ( lastFocused ) {
			lastFocused.focus();
			lastFocused = null;
		}
	}

} )();
