document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay');
    const content = overlay?.querySelector('.overlay-content');

    if (!overlay || !content) return;

    // Close overlay when clicking outside the content box
    overlay.addEventListener('click', (event) => {
        if (event.target === overlay) {
            closeOverlay();
        }
    });

    // Close overlay on Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && overlay.classList.contains('show')) {
            closeOverlay();
        }
    });
});

/**
 * Opens the overlay with optional HTML content.
 * @param {string|null} html Optional HTML string to inject into the overlay content.
 */
function showOverlay(html = null) {
    const overlay = document.getElementById('overlay');
    const content = overlay?.querySelector('.overlay-content');

    if (!overlay || !content) return;

    if (html) {
        content.innerHTML = html;
    }

    overlay.classList.add('show');
    document.body.style.overflow = 'hidden'; // Prevent background scroll
}

/**
 * Closes the overlay and resets content.
 */
function closeOverlay() {
    const overlay = document.getElementById('overlay');
    const content = overlay?.querySelector('.overlay-content');

    if (!overlay || !content) return;

    overlay.classList.remove('show');
    document.body.style.overflow = ''; // Re-enable background scroll
    content.innerHTML = ''; // clean up old content
}
