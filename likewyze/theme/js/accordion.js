/**
 * Accordion Functionality for FAQ Block
 *
 * @package Likewize
 */

(function() {
    'use strict';

    /**
     * Initialize accordion functionality
     */
    function initAccordions() {
        // Find all accordion buttons
        const accordionButtons = document.querySelectorAll('.likewize-accordion-button');

        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                toggleAccordion(this);
            });
        });
    }

    /**
     * Toggle accordion item
     */
    function toggleAccordion(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg, i[data-lucide]');

        // Toggle current item
        if (content.style.maxHeight) {
            // Close current
            content.style.maxHeight = null;
            content.classList.remove('active');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        } else {
            // Close all others (single-item-open mode)
            const allContents = document.querySelectorAll('.likewize-accordion-content');
            allContents.forEach(el => {
                el.style.maxHeight = null;
                el.classList.remove('active');

                // Reset icon
                const btn = el.previousElementSibling;
                if (btn) {
                    const btnIcon = btn.querySelector('svg, i[data-lucide]');
                    if (btnIcon) {
                        btnIcon.style.transform = 'rotate(0deg)';
                    }
                }
            });

            // Open current
            content.style.maxHeight = content.scrollHeight + 'px';
            content.classList.add('active');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAccordions);
    } else {
        initAccordions();
    }

    // Re-initialize after Lucide icons load
    window.addEventListener('load', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
})();
