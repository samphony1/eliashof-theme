document.addEventListener('DOMContentLoaded', function() {
    const config = window.eliashofInternDrawer || {};
    const drawer = document.querySelector('[data-intern-drawer]');

    if (!drawer) {
        return;
    }

    const panel = drawer.querySelector('.eliashof-intern-drawer__panel');
    const backdrop = drawer.querySelector('.eliashof-intern-drawer__backdrop');
    const handle = drawer.querySelector('.eliashof-intern-drawer__handle');
    const header = drawer.querySelector('.eliashof-intern-drawer__header');
    const title = drawer.querySelector('.eliashof-intern-drawer__title');
    const body = drawer.querySelector('[data-intern-drawer-body]');
    const closeButtons = drawer.querySelectorAll('[data-intern-drawer-close]');
    const internPosts = Array.isArray(config.internPosts) ? config.internPosts : [];
	let themeColorMeta = document.querySelector('meta[name="theme-color"]');
	const hadThemeColorMeta = Boolean(themeColorMeta);
	const initialThemeColor = themeColorMeta ? themeColorMeta.getAttribute('content') : '';

    let activePost = null;
    let activeTrigger = null;
    let isOpen = false;
    let lastFocusedElement = null;
    let dragState = null;

    const internPostsById = new Map();
    const internPostsByPath = new Map();
    const internPostsBySlug = new Map();

    internPosts.forEach(function(post) {
        const normalizedPath = normalizePath(post && (post.path || post.permalink || ''));
        const numericId = Number(post && post.id);

        if (!Number.isNaN(numericId) && numericId > 0) {
            internPostsById.set(numericId, post);
        }

        if (normalizedPath) {
            internPostsByPath.set(normalizedPath, post);
        }

        if (post && post.slug) {
            internPostsBySlug.set(post.slug, post);
        }
    });

    function normalizePath(input) {
        if (!input) {
            return '';
        }

        try {
            const url = new URL(input, window.location.origin);
            const pathname = url.pathname.replace(/\/+$/, '');
            return pathname || '/';
        } catch (error) {
            return '';
        }
    }

    function setScrollLock(isLocked) {
        if (typeof window.eliashofSetScrollLock === 'function') {
            window.eliashofSetScrollLock('intern-drawer', isLocked);
            return;
        }

        document.body.style.overflow = isLocked ? 'hidden' : '';
    }

	function setBrowserThemeColor(isDrawerOpen) {
		if (!themeColorMeta && isDrawerOpen) {
			themeColorMeta = document.createElement('meta');
			themeColorMeta.setAttribute('name', 'theme-color');
			document.head.appendChild(themeColorMeta);
		}

		if (!themeColorMeta) {
			return;
		}

		if (isDrawerOpen) {
			const drawerColor = window.getComputedStyle(panel).backgroundColor;
			themeColorMeta.setAttribute('content', drawerColor || '#ffdcac');
			return;
		}

		if (hadThemeColorMeta) {
			themeColorMeta.setAttribute('content', initialThemeColor || '#ffffff');
		} else {
			themeColorMeta.remove();
			themeColorMeta = null;
		}
	}

    function getCurrentUrl() {
        return new URL(window.location.href);
    }

    function getBaseUrl() {
        const url = getCurrentUrl();
        url.searchParams.delete('intern');
        url.searchParams.delete('internFrom');
        return url.toString();
    }

    function getDrawerUrl(post, trigger) {
        const url = new URL(getBaseUrl());
        url.searchParams.set('intern', post.slug);
        const triggerOrigin = getTriggerOrigin(trigger);
        if (triggerOrigin) {
            url.searchParams.set('internFrom', triggerOrigin);
            url.hash = triggerOrigin;
        }
        return url.toString();
    }

    function getInternSlugFromUrl() {
        return getCurrentUrl().searchParams.get('intern') || '';
    }

    function getInternOriginFromUrl() {
        return getCurrentUrl().searchParams.get('internFrom') || '';
    }

    function getTriggerOrigin(trigger) {
        if (!trigger) {
            return '';
        }

        const originElement = trigger.closest('[id]');
        return originElement && originElement.id ? originElement.id : '';
    }

    function findTriggerForPost(post, preferredOrigin) {
        if (!post || !post.id) {
            return null;
        }

        const selector = 'a[data-intern-post-id="' + post.id + '"]';

        if (preferredOrigin) {
            const originElement = document.getElementById(preferredOrigin);
            if (originElement) {
                const scopedMatch = originElement.querySelector(selector);
                if (scopedMatch) {
                    return scopedMatch;
                }
            }
        }

        return document.querySelector(selector);
    }

    function scrollTriggerIntoView(trigger) {
        if (!trigger || typeof trigger.scrollIntoView !== 'function') {
            return;
        }

        trigger.scrollIntoView({
            behavior: 'auto',
            block: 'center',
            inline: 'nearest'
        });
    }

    function scrollOriginIntoView(originId) {
        if (!originId) {
            return;
        }

        const originElement = document.getElementById(originId);
        if (!originElement || typeof originElement.scrollIntoView !== 'function') {
            return;
        }

        originElement.scrollIntoView({
            behavior: 'auto',
            block: 'start',
            inline: 'nearest'
        });
    }

    function syncUrlForOpen(post, options) {
        const settings = options || {};

        if (!post || !post.slug) {
            return;
        }

        const nextUrl = getDrawerUrl(post, settings.trigger || activeTrigger);
        if (window.location.href === nextUrl) {
            return;
        }

        window.history[settings.replaceHistory ? 'replaceState' : 'pushState'](
            {
                eliashofInternDrawer: true,
                postId: post.id,
                postSlug: post.slug
            },
            '',
            nextUrl
        );
    }

    function syncUrlForClose() {
        const baseUrl = getBaseUrl();

        if (window.location.href === baseUrl) {
            return;
        }

        window.history.replaceState(
            {
                eliashofInternDrawer: false
            },
            '',
            baseUrl
        );
    }

    function setLoadingState(message) {
        drawer.classList.remove('is-ready', 'is-error');
        drawer.classList.add('is-loading');
        title.textContent = '';
        body.innerHTML = '<div class="eliashof-intern-drawer__status">' + escapeHtml(message || '') + '</div>';
    }

    function setErrorState(message) {
        drawer.classList.remove('is-loading', 'is-ready');
        drawer.classList.add('is-error');
        title.textContent = '';
        body.innerHTML = '<div class="eliashof-intern-drawer__status">' + escapeHtml(message || '') + '</div>';
    }

    function setReadyState(post) {
        drawer.classList.remove('is-loading', 'is-error');
        drawer.classList.add('is-ready');
        title.textContent = post.title || '';
        body.innerHTML = post.content || '';
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function findPostForLink(link) {
        if (!link) {
            return null;
        }

        const postId = Number(link.getAttribute('data-intern-post-id'));
        if (!Number.isNaN(postId) && internPostsById.has(postId)) {
            return internPostsById.get(postId);
        }

        return internPostsByPath.get(normalizePath(link.href)) || null;
    }

    function focusPanel() {
        window.requestAnimationFrame(function() {
            panel.focus();
        });
    }

    function isMobileSheetMode() {
        return window.matchMedia('(max-width: 782px)').matches;
    }

    function resetPanelPresentation() {
        panel.style.removeProperty('transform');
        panel.style.removeProperty('transition');
        if (backdrop) {
            backdrop.style.removeProperty('opacity');
            backdrop.style.removeProperty('transition');
        }
        drawer.classList.remove('is-dragging');
    }

    function applyDragOffset(offset) {
        const safeOffset = Math.max(0, offset);
        const panelHeight = panel.offsetHeight || 1;
        const progress = Math.min(safeOffset / panelHeight, 1);

        panel.style.transform = 'translateY(' + safeOffset + 'px)';
        if (backdrop) {
            backdrop.style.opacity = String(Math.max(0, 1 - progress * 1.35));
        }
    }

    function stopDraggingSheet() {
        if (!dragState) {
            return;
        }

        if (typeof panel.releasePointerCapture === 'function') {
            try {
                panel.releasePointerCapture(dragState.pointerId);
            } catch (error) {
                // Ignore pointer capture release issues.
            }
        }

        dragState = null;
    }

    function animateSheetBack() {
        panel.style.transition = 'transform 0.24s cubic-bezier(0.22, 1, 0.36, 1)';
        if (backdrop) {
            backdrop.style.transition = 'opacity 0.24s ease';
        }
        applyDragOffset(0);

        window.setTimeout(function() {
            if (isOpen) {
                resetPanelPresentation();
            }
        }, 260);
    }

    function openDrawerShell() {
        if (isOpen) {
            return;
        }

        lastFocusedElement = document.activeElement;
        isOpen = true;
        drawer.hidden = false;
        drawer.classList.add('is-open');
        document.documentElement.classList.add('has-eliashof-drawer-open');
        setScrollLock(true);
		setBrowserThemeColor(true);
        resetPanelPresentation();
        focusPanel();
    }

    function openPreviewDrawer(color) {
        if (color) {
            document.documentElement.style.setProperty('--eliashof-drawer-background', color);
        }

        openDrawerShell();
        drawer.classList.remove('is-loading', 'is-error');
        drawer.classList.add('is-ready');
        title.textContent = 'Drawer Vorschau';
        body.innerHTML = [
            '<h2>Beispielinhalt</h2>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
            '<h3>Weitere Informationen</h3>',
            '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            '<ul>',
            '<li>Ein kurzer Beispielpunkt</li>',
            '<li>Ein weiterer Eintrag zur Ansicht</li>',
            '<li>Kontrast und Lesbarkeit prüfen</li>',
            '</ul>',
            '<p><a href="#" onclick="return false;">Beispiel-Link ansehen</a></p>'
        ].join('');
    }

    window.eliashofPreviewDrawer = openPreviewDrawer;
    window.addEventListener('eliashof:preview-drawer', function() {
        openPreviewDrawer();
    });

    function closeDrawer(options) {
        const settings = options || {};

        if (!isOpen) {
            return;
        }

        stopDraggingSheet();
        resetPanelPresentation();
        isOpen = false;
        drawer.classList.remove('is-open', 'is-loading', 'is-ready', 'is-error');
        document.documentElement.classList.remove('has-eliashof-drawer-open');
        setScrollLock(false);
		setBrowserThemeColor(false);

        window.setTimeout(function() {
            if (!isOpen) {
                drawer.hidden = true;
                title.textContent = '';
                body.innerHTML = '';
            }
        }, 360);

        if (!settings.skipFocusRestore && lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }

        activePost = null;
        activeTrigger = null;

        if (!settings.skipHistory) {
            syncUrlForClose();
        }
    }

    async function fetchPost(post) {
        const response = await window.fetch(config.restBase + post.id, {
            headers: {
                Accept: 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('fetch_failed');
        }

        return response.json();
    }

    async function openPost(post, trigger, options) {
        if (!post || !post.id) {
            return;
        }

        const settings = options || {};
        const wasOpen = isOpen;
        activePost = post;
        activeTrigger = trigger || null;
        openDrawerShell();
        setLoadingState(config.labels && config.labels.loading ? config.labels.loading : 'Loading…');

        try {
            const payload = await fetchPost(post);

            if (!isOpen || !activePost || Number(activePost.id) !== Number(post.id)) {
                return;
            }

            setReadyState(payload);

            if (!settings.skipHistoryUpdate) {
                syncUrlForOpen(post, {
                    replaceHistory: settings.replaceHistory || wasOpen,
                    trigger: trigger || activeTrigger
                });
            }
        } catch (error) {
            setErrorState(config.labels && config.labels.error ? config.labels.error : 'Unable to load this content.');

            window.setTimeout(function() {
                if (post.permalink) {
                    window.location.href = post.permalink;
                }
            }, 900);
        }
    }

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            closeDrawer();
        });
    });

    panel.addEventListener('pointerdown', function(event) {
        const isDragHandleTarget = event.target.closest('.eliashof-intern-drawer__handle, .eliashof-intern-drawer__header');
        const isCloseTarget = event.target.closest('.eliashof-intern-drawer__close');

        if (
            !isOpen ||
            !isMobileSheetMode() ||
            !isDragHandleTarget ||
            isCloseTarget ||
            event.pointerType === 'mouse' && event.button !== 0
        ) {
            return;
        }

        dragState = {
            pointerId: event.pointerId,
            startY: event.clientY,
            currentY: event.clientY,
            startTime: Date.now()
        };

        drawer.classList.add('is-dragging');
        panel.style.transition = 'none';
        if (backdrop) {
            backdrop.style.transition = 'none';
        }

        if (typeof panel.setPointerCapture === 'function') {
            panel.setPointerCapture(event.pointerId);
        }
    });

    panel.addEventListener('pointermove', function(event) {
        if (!dragState || event.pointerId !== dragState.pointerId) {
            return;
        }

        const deltaY = event.clientY - dragState.startY;
        dragState.currentY = event.clientY;

        if (deltaY <= 0) {
            applyDragOffset(0);
            return;
        }

        applyDragOffset(deltaY);
    });

    function finishSheetDrag(event) {
        if (!dragState || event.pointerId !== dragState.pointerId) {
            return;
        }

        const deltaY = Math.max(0, dragState.currentY - dragState.startY);
        const elapsed = Math.max(Date.now() - dragState.startTime, 1);
        const velocity = deltaY / elapsed;
        const closeThreshold = Math.min(Math.max(panel.offsetHeight * 0.18, 110), 220);
        const shouldClose = deltaY > closeThreshold || velocity > 0.9;

        stopDraggingSheet();

        if (shouldClose) {
            closeDrawer();
            return;
        }

        animateSheetBack();
    }

    panel.addEventListener('pointerup', finishSheetDrag);
    panel.addEventListener('pointercancel', finishSheetDrag);

    drawer.addEventListener('click', function(event) {
        if (event.target === drawer.querySelector('.eliashof-intern-drawer__backdrop')) {
            closeDrawer();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && isOpen) {
            closeDrawer();
        }
    });

    window.addEventListener('popstate', function() {
        const internSlug = getInternSlugFromUrl();
        const internOrigin = getInternOriginFromUrl();
        const targetPost = internSlug ? internPostsBySlug.get(internSlug) : null;

        if (targetPost) {
            const trigger = findTriggerForPost(targetPost, internOrigin);
            scrollOriginIntoView(internOrigin);
            scrollTriggerIntoView(trigger);
            openPost(targetPost, null, {
                skipHistoryUpdate: true,
                replaceHistory: true
            });
            return;
        }

        if (isOpen) {
            closeDrawer({
                skipHistory: true
            });
        }
    });

    document.addEventListener('click', function(event) {
        const link = event.target.closest('a[href]');

        if (!link) {
            return;
        }

        if (
            event.defaultPrevented ||
            event.button !== 0 ||
            event.metaKey ||
            event.ctrlKey ||
            event.shiftKey ||
            event.altKey ||
            link.target === '_blank' ||
            link.hasAttribute('download')
        ) {
            return;
        }

        const post = findPostForLink(link);

        if (!post) {
            return;
        }

        const url = new URL(link.href, window.location.origin);
        if (url.origin !== window.location.origin) {
            return;
        }

        event.preventDefault();
        openPost(post, link);
    });

    const initialInternSlug = getInternSlugFromUrl();
    if (initialInternSlug && internPostsBySlug.has(initialInternSlug)) {
        const initialPost = internPostsBySlug.get(initialInternSlug);
        const initialOrigin = getInternOriginFromUrl();
        const initialTrigger = findTriggerForPost(initialPost, initialOrigin);
        scrollOriginIntoView(initialOrigin);
        scrollTriggerIntoView(initialTrigger);
        openPost(initialPost, initialTrigger, {
            skipHistoryUpdate: true,
            replaceHistory: true
        });
    }
});
