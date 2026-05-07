/**
 * Eliashof Carousel — vanilla JS scroll-snap dot navigation
 * Targets: .eliashof-aktuelles-carousel
 * No jQuery, no external dependencies.
 */
(function () {
	'use strict';

	function initCarousel(carousel) {
		const track = carousel.querySelector('.wp-block-post-template');
		if (!track) return;
		const items = Array.from(track.children);
		if (items.length < 2) return;

		// Create dots container and insert it after the query block (inside the section)
		const dotsContainer = document.createElement('div');
		dotsContainer.className = 'eliashof-carousel-dots';
		dotsContainer.setAttribute('role', 'tablist');
		dotsContainer.setAttribute('aria-label', 'Karussell-Navigation');
		carousel.parentNode.insertBefore(dotsContainer, carousel.nextSibling);

		let dots = [];

		function getVisibleCount() {
			const itemWidth = items[0] ? items[0].getBoundingClientRect().width : 0;
			const trackWidth = track.getBoundingClientRect().width;
			return itemWidth > 0 ? Math.max(1, Math.round(trackWidth / itemWidth)) : 1;
		}

		function buildDots() {
			dotsContainer.innerHTML = '';
			dots = [];
			const groupCount = Math.ceil(items.length / getVisibleCount());

			if (groupCount <= 1) {
				dotsContainer.style.display = 'none';
				return;
			}

			dotsContainer.style.display = 'flex';

			for (let i = 0; i < groupCount; i++) {
				const dot = document.createElement('button');
				dot.className = 'eliashof-carousel-dot';
				dot.setAttribute('role', 'tab');
				dot.setAttribute('aria-label', 'Seite ' + (i + 1));
				dot.setAttribute('aria-current', i === 0 ? 'true' : 'false');

				// Capture i for click handler
				(function (index) {
					dot.addEventListener('click', function () {
						const target = items[index * getVisibleCount()];
						if (target) {
							const targetLeft = target.offsetLeft - track.offsetLeft;
							track.scrollTo({
								left: targetLeft,
								behavior: 'smooth'
							});
						}
					});
				})(i);

				dotsContainer.appendChild(dot);
				dots.push(dot);
			}

			updateActiveDot();
		}

		function updateActiveDot() {
			if (!dots.length) return;
			const max = track.scrollWidth - track.getBoundingClientRect().width;
			const idx = max > 0
				? Math.round((track.scrollLeft / max) * (dots.length - 1))
				: 0;

			dots.forEach(function (d, i) {
				const active = i === idx;
				d.classList.toggle('is-active', active);
				d.setAttribute('aria-current', active ? 'true' : 'false');
			});
		}

		// Scroll listener — throttled via requestAnimationFrame
		let raf = null;
		track.addEventListener('scroll', function () {
			if (raf) return;
			raf = requestAnimationFrame(function () {
				updateActiveDot();
				raf = null;
			});
		}, { passive: true });

		// Rebuild dots on container resize (handles responsive breakpoint changes)
		let resizeTimer = null;
		new ResizeObserver(function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(buildDots, 150);
		}).observe(track);

		// Initial build — small delay to let images load and layout settle
		setTimeout(buildDots, 100);
	}

	function init() {
		document.querySelectorAll('.eliashof-aktuelles-carousel').forEach(initCarousel);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
