(function() {
    const STORAGE_KEY = 'eliashof-text-size';
    const MIN_SCALE = 80;
    const MAX_SCALE = 150;
    const STEP = 10;
    const TEXT_SELECTOR = [
        'p', 'li', 'a', 'button', 'label', 'input', 'textarea', 'select',
        'blockquote', 'figcaption', 'dt', 'dd', 'td', 'th',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
    ].join(',');
    const EXCLUDED_SELECTOR = [
        '.eliashof-header',
        '.eliashof-text-size',
        '.screen-reader-text',
        'script',
        'style',
        'svg'
    ].join(',');

    function readSavedScale() {
        const value = Number.parseInt(window.localStorage.getItem(STORAGE_KEY), 10);
        return value >= MIN_SCALE && value <= MAX_SCALE && value % STEP === 0 ? value : 100;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const widget = document.querySelector('.eliashof-text-size');

        if (!widget) {
            return;
        }

        const trigger = widget.querySelector('.eliashof-text-size__trigger');
        const menu = widget.querySelector('.eliashof-text-size__menu');
        const decreaseButton = widget.querySelector('.eliashof-text-size__button--decrease');
        const resetButton = widget.querySelector('.eliashof-text-size__button--reset');
        const increaseButton = widget.querySelector('.eliashof-text-size__button--increase');
        const status = widget.querySelector('.eliashof-text-size__status');
        const baseSizes = new WeakMap();
        const originalInlineSizes = new WeakMap();
        const originalInlinePriorities = new WeakMap();
        let scale = readSavedScale();

        function getTextElements(root) {
            const elements = [];

            if (root.nodeType === Node.ELEMENT_NODE && root.matches(TEXT_SELECTOR)) {
                elements.push(root);
            }

            if (root.querySelectorAll) {
                elements.push.apply(elements, root.querySelectorAll(TEXT_SELECTOR));
            }

            return elements.filter(function(element) {
                return !element.closest(EXCLUDED_SELECTOR);
            });
        }

        function scaleElements(root) {
            const elements = getTextElements(root);

            elements.forEach(function(element) {
                if (!baseSizes.has(element)) {
                    originalInlineSizes.set(element, element.style.fontSize);
                    originalInlinePriorities.set(element, element.style.getPropertyPriority('font-size'));
                    baseSizes.set(element, Number.parseFloat(window.getComputedStyle(element).fontSize));
                }
            });

            elements.forEach(function(element) {
                const baseSize = baseSizes.get(element);
                if (Number.isFinite(baseSize)) {
                    if (scale === 100) {
                        element.style.setProperty(
                            'font-size',
                            originalInlineSizes.get(element),
                            originalInlinePriorities.get(element)
                        );
                    } else {
                        let elementScale = scale;

                        if (baseSize >= 48) {
                            elementScale = 100 + ((scale - 100) * 0.06);
                        } else if (element.matches('h1, h2, h3, h4, h5, h6')) {
                            elementScale = 100 + ((scale - 100) / 2);
                        }
                        element.style.setProperty(
                            'font-size',
                            (baseSize * elementScale / 100).toFixed(2) + 'px',
                            'important'
                        );
                    }
                }
            });
        }

        function updateControls(announce) {
            decreaseButton.disabled = scale === MIN_SCALE;
            resetButton.disabled = scale === 100;
            increaseButton.disabled = scale === MAX_SCALE;
            widget.dataset.scale = String(scale);
            widget.setAttribute('aria-label', 'Textgröße ändern, aktuell ' + scale + ' Prozent');

            if (announce) {
                status.textContent = 'Textgröße ' + scale + ' Prozent';
            }
        }

        function applyScale(announce) {
            scaleElements(document.body);
            updateControls(announce);
            window.localStorage.setItem(STORAGE_KEY, String(scale));
        }

        decreaseButton.addEventListener('click', function() {
            scale = Math.max(MIN_SCALE, scale - STEP);
            applyScale(true);
        });

        increaseButton.addEventListener('click', function() {
            scale = Math.min(MAX_SCALE, scale + STEP);
            applyScale(true);
        });

        resetButton.addEventListener('click', function() {
            scale = 100;
            applyScale(true);
        });

        function setMenuOpen(open) {
            menu.hidden = !open;
            trigger.setAttribute('aria-expanded', String(open));
        }

        trigger.addEventListener('click', function() {
            setMenuOpen(trigger.getAttribute('aria-expanded') !== 'true');
        });

        document.addEventListener('click', function(event) {
            if (!widget.contains(event.target)) {
                setMenuOpen(false);
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && trigger.getAttribute('aria-expanded') === 'true') {
                setMenuOpen(false);
                trigger.focus();
            }
        });

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        scaleElements(node);
                    }
                });
            });
        });

        applyScale(false);
        observer.observe(document.body, { childList: true, subtree: true });
    });
})();
