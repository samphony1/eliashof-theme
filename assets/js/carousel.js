/**
 * Eliashof Carousel — vanilla JS scroll-snap dot navigation
 * Targets: .eliashof-aktuelles-carousel
 * No jQuery, no external dependencies.
 */
(function () {
	'use strict';

	function initCarousel(carousel) {
		if (carousel.dataset.eliashofCarouselReady === 'true') return;
		const track = carousel.querySelector('.wp-block-post-template');
		if (!track) return;
		const items = Array.from(track.children);
		if (items.length < 2) return;
		carousel.dataset.eliashofCarouselReady = 'true';
		const section = carousel.closest('.eliashof-section') || carousel.parentNode;
		section.classList.add('eliashof-has-post-carousel');

		// Shared controls: desktop arrows around the existing dot navigation.
		const controlsContainer = document.createElement('div');
		controlsContainer.className = 'eliashof-carousel-controls';
		controlsContainer.setAttribute('aria-label', 'Karussell-Steuerung');

		const previousButton = document.createElement('button');
		previousButton.type = 'button';
		previousButton.className = 'eliashof-carousel-arrow eliashof-carousel-arrow--previous';
		previousButton.setAttribute('aria-label', 'Vorherige Beiträge');
		previousButton.innerHTML = '<svg aria-hidden="true" viewBox="0 0 24 24" focusable="false"><path d="M14.5 5 7.5 12l7 7"/></svg>';

		const dotsContainer = document.createElement('div');
		dotsContainer.className = 'eliashof-carousel-dots';
		dotsContainer.setAttribute('role', 'tablist');
		dotsContainer.setAttribute('aria-label', 'Karussell-Navigation');

		const nextButton = document.createElement('button');
		nextButton.type = 'button';
		nextButton.className = 'eliashof-carousel-arrow eliashof-carousel-arrow--next';
		nextButton.setAttribute('aria-label', 'Weitere Beiträge');
		nextButton.innerHTML = '<svg aria-hidden="true" viewBox="0 0 24 24" focusable="false"><path d="m9.5 5 7 7-7 7"/></svg>';

		controlsContainer.appendChild(dotsContainer);
		section.appendChild(previousButton);
		section.appendChild(nextButton);
		carousel.parentNode.insertBefore(controlsContainer, carousel.nextSibling);

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
				controlsContainer.hidden = true;
				return;
			}

			controlsContainer.hidden = false;
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
			const max = track.scrollWidth - track.getBoundingClientRect().width;
			const idx = max > 0
				? Math.round((track.scrollLeft / max) * (dots.length - 1))
				: 0;
			const tolerance = 2;
			previousButton.disabled = track.scrollLeft <= tolerance;
			nextButton.disabled = track.scrollLeft >= max - tolerance;

			dots.forEach(function (d, i) {
				const active = i === idx;
				d.classList.toggle('is-active', active);
				d.setAttribute('aria-current', active ? 'true' : 'false');
			});
		}

		function scrollByPage(direction) {
			const visibleCount = getVisibleCount();
			const currentIndex = items.reduce(function (closest, item, index) {
				return Math.abs(item.offsetLeft - track.offsetLeft - track.scrollLeft) <
					Math.abs(items[closest].offsetLeft - track.offsetLeft - track.scrollLeft) ? index : closest;
			}, 0);
			const targetIndex = Math.max(0, Math.min(items.length - 1, currentIndex + direction * visibleCount));
			track.scrollTo({
				left: items[targetIndex].offsetLeft - track.offsetLeft,
				behavior: 'smooth'
			});
		}

		previousButton.addEventListener('click', function () { scrollByPage(-1); });
		nextButton.addEventListener('click', function () { scrollByPage(1); });

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
