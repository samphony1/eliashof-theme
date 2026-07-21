document.addEventListener('DOMContentLoaded', function() {
    const scrollLockSources = new Set();

    window.eliashofSetScrollLock = function(source, locked) {
        if (!source) {
            return;
        }

        if (locked) {
            scrollLockSources.add(source);
        } else {
            scrollLockSources.delete(source);
        }

        document.body.style.overflow = scrollLockSources.size > 0 ? 'hidden' : '';
    };

    const burgerToggle = document.querySelector('.burger-toggle');
    const burgerMenuOverlay = document.querySelector('.burger-menu-overlay');

    if (burgerToggle && burgerMenuOverlay) {
        const submenuParents = burgerMenuOverlay.querySelectorAll('.menu-item-has-children');

        submenuParents.forEach(function(menuItem, index) {
            const parentLink = menuItem.querySelector(':scope > a');
            const submenu = menuItem.querySelector(':scope > .sub-menu');

            if (!parentLink || !submenu) {
                return;
            }

            const submenuId = 'burger-submenu-' + index;
            const submenuToggle = document.createElement('button');
            submenu.id = submenuId;
            submenu.hidden = true;
            submenuToggle.type = 'button';
            submenuToggle.className = 'submenu-toggle';
            submenuToggle.setAttribute('aria-expanded', 'false');
            submenuToggle.setAttribute('aria-controls', submenuId);
            submenuToggle.setAttribute('aria-label', 'Untermenü zu ' + parentLink.textContent.trim() + ' öffnen');
            submenuToggle.innerHTML = '<span aria-hidden="true"></span>';
            parentLink.insertAdjacentElement('afterend', submenuToggle);

            submenuToggle.addEventListener('click', function() {
                const isExpanded = submenuToggle.getAttribute('aria-expanded') === 'true';
                submenuToggle.setAttribute('aria-expanded', String(!isExpanded));
                submenuToggle.setAttribute('aria-label', 'Untermenü zu ' + parentLink.textContent.trim() + ' ' + (isExpanded ? 'öffnen' : 'schließen'));
                submenu.hidden = isExpanded;
                menuItem.classList.toggle('is-submenu-open', !isExpanded);
            });
        });

        function closeSubmenus() {
            submenuParents.forEach(function(menuItem) {
                const parentLink = menuItem.querySelector(':scope > a');
                const submenu = menuItem.querySelector(':scope > .sub-menu');
                const submenuToggle = menuItem.querySelector(':scope > .submenu-toggle');

                if (submenu && submenuToggle) {
                    submenu.hidden = true;
                    submenuToggle.setAttribute('aria-expanded', 'false');
                    submenuToggle.setAttribute('aria-label', 'Untermenü zu ' + parentLink.textContent.trim() + ' öffnen');
                    menuItem.classList.remove('is-submenu-open');
                }
            });
        }

        burgerToggle.addEventListener('click', function() {
            // Toggle active classes
            burgerToggle.classList.toggle('is-active');
            burgerMenuOverlay.classList.toggle('is-active');

            // Update aria-expanded for accessibility
            const isExpanded = burgerToggle.classList.contains('is-active');
            burgerToggle.setAttribute('aria-expanded', isExpanded);

            // Prevent body scrolling when menu is open
            window.eliashofSetScrollLock('burger-menu', isExpanded);

            if (!isExpanded) {
                closeSubmenus();
            }
        });

        // Close menu when clicking on a link
        const menuLinks = burgerMenuOverlay.querySelectorAll('a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                burgerToggle.classList.remove('is-active');
                burgerMenuOverlay.classList.remove('is-active');
                burgerToggle.setAttribute('aria-expanded', 'false');
                window.eliashofSetScrollLock('burger-menu', false);
                closeSubmenus();
            });
        });
    }

    // Back to top button functionality
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('is-visible');
            } else {
                backToTopBtn.classList.remove('is-visible');
            }
        });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
