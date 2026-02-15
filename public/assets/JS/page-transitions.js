/**
 * SMART BUS PORTAL - PROFESSIONAL PAGE TRANSITIONS
 * Global transition system for seamless navigation
 */

(function () {
    'use strict';

    // Configuration
    const TRANSITION_DURATION = 600; // milliseconds
    const TRANSITION_DELAY = 100; // delay before navigation

    // Create and inject loading overlay
    function createLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'page-transition-overlay';
        overlay.innerHTML = `
            <div class="transition-content">
                <div class="bus-loader">
                    <i class="bi bi-bus-front-fill"></i>
                </div>
                <div class="road"></div>
                <p class="transition-text">Travelling...</p>
            </div>
        `;
        document.body.appendChild(overlay);
        return overlay;
    }

    // Add transition styles
    function injectStyles() {
        const style = document.createElement('style');
        style.textContent = `
            /* Page Transition Overlay */
            #page-transition-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 999999;
                opacity: 0;
                pointer-events: none;
                transition: opacity ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            #page-transition-overlay.active {
                opacity: 1;
                pointer-events: all;
            }

            /* Loading Content Fade */

            .transition-content {
                text-align: center;
                animation: fadeInScale 0.4s ease-out;
                position: relative;
                z-index: 10;
            }

            .bus-loader {
                font-size: 4rem;
                color: #ffffff;
                margin-bottom: 20px;
                animation: busBounce 0.8s ease-in-out infinite alternate;
                text-shadow: 0 10px 20px rgba(0,0,0,0.3);
            }

            .road {
                width: 100px;
                height: 4px;
                background: rgba(255,255,255,0.3);
                margin: 0 auto 20px;
                border-radius: 2px;
                position: relative;
                overflow: hidden;
            }

            .road::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: #ffffff;
                animation: roadMove 1s linear infinite;
            }

            .transition-text {
                color: #ffffff;
                font-size: 1.2rem;
                font-weight: 700;
                letter-spacing: 2px;
                text-transform: uppercase;
                margin: 0;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                animation: pulse 1.5s ease-in-out infinite;
            }

            @keyframes busBounce {
                0% { transform: translateY(0); }
                100% { transform: translateY(-10px); }
            }

            @keyframes roadMove {
                0% { left: -100%; }
                100% { left: 100%; }
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }

            /* --- MULTI-DIRECTIONAL TRANSITIONS --- */

            /* Default Entry (Fade Up) */
            body {
                animation: pageEnterUp ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            /* Zoom */
            body.enter-zoom { animation: pageEnterZoom ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }
            body.exit-zoom { animation: pageExitZoom ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }

            /* Up */
            body.enter-up { animation: pageEnterUp ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }
            body.exit-up { animation: pageExitUp ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }

            /* Down */
            body.enter-down { animation: pageEnterDown ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }
            body.exit-down { animation: pageExitDown ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }

            /* Left */
            body.enter-left { animation: pageEnterLeft ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }
            body.exit-left { animation: pageExitLeft ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }

            /* Right */
            body.enter-right { animation: pageEnterRight ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }
            body.exit-right { animation: pageExitRight ${TRANSITION_DURATION}ms cubic-bezier(0.4, 0, 0.2, 1) forwards; }

            /* Standard Transitions */

            /* --- KEYFRAMES --- */

            /* Entry Keyframes */
            @keyframes pageEnterUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes pageEnterDown {
                from { opacity: 0; transform: translateY(-50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes pageEnterLeft {
                from { opacity: 0; transform: translateX(50px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes pageEnterRight {
                from { opacity: 0; transform: translateX(-50px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes pageEnterZoom {
                from { opacity: 0; transform: scale(0.9); }
                to { opacity: 1; transform: scale(1); }
            }
            /* Standard Out animations */
            @keyframes pageExitUp {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-50px); }
            }
            @keyframes pageExitDown {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(50px); }
            }
            @keyframes pageExitLeft {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(-50px); }
            }
            @keyframes pageExitRight {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(50px); }
            }
            @keyframes pageExitZoom {
                from { opacity: 1; transform: scale(1); }
                to { opacity: 0; transform: scale(1.1); }
            }

            @keyframes fadeInScale {
                from { opacity: 0; transform: scale(0.8); }
                to { opacity: 1; transform: scale(1); }
            }

            /* Prevent layout shift during transitions */
            html { overflow-x: hidden; }

            /* Reduced motion support */
            @media (prefers-reduced-motion: reduce) {
                body, #page-transition-overlay, .bus-loader, .road::after, .transition-text, .split-panel {
                    animation: none !important;
                    transition: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Get transition type based on URL
    function getTransitionType(url) {
        try {
            const urlObj = new URL(url, window.location.origin);
            const path = urlObj.pathname;

            if (path.includes('passenger_login.php')) return 'up';
            if (path.includes('index.php')) return 'up';
            if (path.includes('about.php')) return 'down';
            if (path.includes('community.php')) return 'left';
            if (path.includes('creator.php')) return 'right';
            if (path.includes('settings.php') || path.includes('dashboard')) return 'zoom';
        } catch (e) {
            console.error('Error parsing URL for transition:', e);
        }

        // Random selection for others
        const types = ['up', 'down', 'left', 'right', 'zoom'];
        return types[Math.floor(Math.random() * types.length)];
    }

    // Navigate with transition
    function navigateWithTransition(url, event) {
        if (event) {
            event.preventDefault();
        }

        // Don't transition if it's the same page
        if (url === window.location.href) {
            return;
        }

        const transitionType = getTransitionType(url);

        // Store for next page entry
        sessionStorage.setItem('page-transition-direction', transitionType);

        // Show overlay
        const overlay = document.getElementById('page-transition-overlay');
        if (overlay) {
            overlay.classList.add('active');
        }

        // Add exit animation to body
        document.body.classList.add(`exit-${transitionType}`);

        // Navigate after animation
        setTimeout(() => {
            window.location.href = url;
        }, TRANSITION_DURATION + TRANSITION_DELAY);
    }

    // Initialize transition system
    function init() {
        // Inject styles
        injectStyles();

        // Check for persisted entry transition
        const entryTransition = sessionStorage.getItem('page-transition-direction');
        if (entryTransition) {
            const bodyClass = `enter-${entryTransition}`;
            document.body.className = bodyClass;
            // Clear it for next time
            sessionStorage.removeItem('page-transition-direction');
        }

        // Create overlay
        const overlay = createLoadingOverlay();

        // Handle all anchor clicks
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');

            // Only handle internal links
            if (link &&
                link.href &&
                link.href.indexOf(window.location.origin) === 0 &&
                !link.hasAttribute('target') &&
                !link.hasAttribute('data-no-transition') &&
                !link.href.includes('#') &&
                !link.classList.contains('no-transition')) {

                navigateWithTransition(link.href, e);
            }
        });

        // Handle browser back/forward
        window.addEventListener('pageshow', function (event) {
            // Remove overlay if coming back via history
            if (event.persisted) {
                overlay.classList.remove('active');
                overlay.classList.remove('split-active');
                document.body.className = '';
            }
        });

        // Handle form submissions with transitions
        document.addEventListener('submit', function (e) {
            const form = e.target;

            // Only add transition for GET forms or forms with data-transition
            if (form.method.toLowerCase() === 'get' || form.hasAttribute('data-transition')) {
                const transitionType = getTransitionType(form.action || window.location.href);
                sessionStorage.setItem('page-transition-direction', transitionType);

                overlay.classList.add('active');
                document.body.classList.add(`exit-${transitionType}`);
            }
        });

        // Expose global navigation function
        window.navigateWithTransition = navigateWithTransition;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Hide overlay on page load (in case of back button)
    window.addEventListener('load', function () {
        const overlay = document.getElementById('page-transition-overlay');
        if (overlay) {
            setTimeout(() => {
                overlay.classList.remove('active');
                overlay.classList.remove('split-active');
            }, 100);
        }
    });
})();
