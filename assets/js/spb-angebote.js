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

		const mobileQuery = window.matchMedia( '(max-width: 600px)' );

		function centerTabInList( tab ) {
			if ( ! tab ) return;

			/* scrollIntoView() may move the page itself when the final tab is
			   close to the viewport edge. Scroll only the tablist instead. */
			const desiredLeft = tab.offsetLeft - ( tabList.clientWidth - tab.offsetWidth ) / 2;
			const maxLeft = Math.max( 0, tabList.scrollWidth - tabList.clientWidth );

			tabList.scrollTo( {
				left: Math.max( 0, Math.min( desiredLeft, maxLeft ) ),
				behavior: 'smooth'
			} );
		}

		function activateTab( index, scrollTabIntoView ) {
			tabs.forEach( function ( tab, i ) {
				const isActive = ( i === index );
				tab.setAttribute( 'aria-selected', isActive ? 'true' : 'false' );
				tab.tabIndex = isActive ? 0 : -1;
			} );
			panels.forEach( function ( panel, i ) {
				if ( ! panel ) return;
				const isActive = ( i === index );
				panel.classList.toggle( 'is-active-tab', isActive );
				panel.hidden = mobileQuery.matches && ! isActive;
			} );

			if ( mobileQuery.matches && scrollTabIntoView && tabs[ index ] ) {
				centerTabInList( tabs[ index ] );
			}
		}

		// Set initial state (first tab active)
		activateTab( 0, false );

		tabs.forEach( function ( tab, index ) {
			tab.addEventListener( 'click', function () {
				activateTab( index, true );
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
				activateTab( next, true );
				tabs[ next ].focus( { preventScroll: true } );
			} );
		} );

		mobileQuery.addEventListener( 'change', function() {
			const activeIndex = tabs.findIndex( function( tab ) { return tab.getAttribute( 'aria-selected' ) === 'true'; } );
			activateTab( activeIndex >= 0 ? activeIndex : 0, false );
		} );
	}

} )();
