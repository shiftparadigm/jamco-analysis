/**
 * Main JavaScript for Likewize Theme
 *
 * @package Likewize
 */

(function() {
    'use strict';

    /**
     * Initialize Lucide icons
     */
    function initIcons() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                // Skip if href is just "#"
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Initialize all components
     */
    function init() {
        initIcons();
        initSmoothScroll();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Re-initialize icons after window load (in case Lucide loads late)
    window.addEventListener('load', initIcons);
})();
