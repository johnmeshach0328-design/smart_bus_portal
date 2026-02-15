// Theme-Adaptive Text Color Loader
// This script ensures text colors automatically adapt to the selected theme

(function () {
    'use strict';

    // Function to apply theme-based text colors
    function applyThemeTextColors() {
        // Get the current theme's text color from CSS variable
        const textColor = getComputedStyle(document.documentElement).getPropertyValue('--text-main').trim();
        const headingColor = getComputedStyle(document.documentElement).getPropertyValue('--text-heading').trim();

        if (!textColor) {
            // Theme not loaded yet, wait a bit
            setTimeout(applyThemeTextColors, 100);
            return;
        }

        // Apply theme colors to ALL text elements
        const style = document.getElementById('themeAdaptiveTextStyle') || document.createElement('style');
        style.id = 'themeAdaptiveTextStyle';
        style.textContent = `
            /* Apply theme text color to all elements */
            body, body *, 
            p, span, div, label, a,
            input, textarea, select, option,
            li, td, th, caption, small, strong, em,
            .form-label, .form-control, .navbar-brand, .nav-link,
            .card-text, .alert,
            .section-label, .lang-btn, .theme-card,
            .district-card span, .district-card h6 {
                color: var(--text-main) !important;
            }
            
            /* Apply heading colors - but exclude district cards */
            h1, h2, h3, h4, h6,
            .card-title, .text-heading {
                color: var(--text-heading) !important;
            }
            
            
            /* District card names follow the active theme */
            body .district-card h6,
            .district-card h6,
            .district-card h6 span {
                color: var(--text-heading) !important;
                text-shadow: none !important;
            }
            
            /* Ensure inputs and form elements use theme colors */
            input, textarea, select {
                color: var(--input-text, var(--text-main)) !important;
            }
            
            /* Placeholder colors */
            ::placeholder {
                color: var(--text-main) !important;
                opacity: 0.6 !important;
            }
            
            /* Override Bootstrap text utilities to use theme colors */
            .text-white, .text-light {
                color: var(--text-main) !important;
            }
            
            .text-muted {
                color: var(--text-main) !important;
                opacity: 0.7 !important;
            }
            
            /* Ensure icons are visible */
            i.bi {
                color: var(--text-main) !important;
            }
        `;

        if (!document.getElementById('themeAdaptiveTextStyle')) {
            document.head.appendChild(style);
        }
    }

    // Apply immediately
    applyThemeTextColors();

    // Re-apply when theme changes
    window.addEventListener('themeChanged', applyThemeTextColors);

    // Re-apply after DOM is fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applyThemeTextColors);
    }

    // Re-apply after a short delay to ensure theme-manager has run
    setTimeout(applyThemeTextColors, 50);
    setTimeout(applyThemeTextColors, 200);
})();
