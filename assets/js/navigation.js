document.addEventListener('DOMContentLoaded', function() {
    const burgerToggle = document.querySelector('.burger-toggle');
    const burgerMenuOverlay = document.querySelector('.burger-menu-overlay');

    if (burgerToggle && burgerMenuOverlay) {
        burgerToggle.addEventListener('click', function() {
            // Toggle active classes
            burgerToggle.classList.toggle('is-active');
            burgerMenuOverlay.classList.toggle('is-active');

            // Update aria-expanded for accessibility
            const isExpanded = burgerToggle.classList.contains('is-active');
            burgerToggle.setAttribute('aria-expanded', isExpanded);

            // Prevent body scrolling when menu is open
            if (isExpanded) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // Close menu when clicking on a link
        const menuLinks = burgerMenuOverlay.querySelectorAll('a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                burgerToggle.classList.remove('is-active');
                burgerMenuOverlay.classList.remove('is-active');
                burgerToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
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