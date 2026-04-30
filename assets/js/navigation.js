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
    }
});
