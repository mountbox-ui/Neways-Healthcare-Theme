/**
 * Tov Theme JavaScript
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initMobileSubmenu();
        initSearchToggle();
        initSmoothScrolling();
        initFocusManagement();
    });

    /**
     * Initialize mobile menu functionality
     */
    function initMobileMenu() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileNavigation = document.getElementById('mobile-navigation');


        if (mobileMenuButton && mobileNavigation) {
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                const newState = !isExpanded;
                
                // Update aria-expanded
                mobileMenuButton.setAttribute('aria-expanded', newState);
                
                // Toggle menu visibility
                if (newState) {
                    mobileNavigation.classList.remove('hidden');
                } else {
                    mobileNavigation.classList.add('hidden');
                }
                
                // Update button icon
                const icon = mobileMenuButton.querySelector('svg path');
                if (icon) {
                    if (newState) {
                        // Show X icon when menu is open
                        icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                    } else {
                        // Show hamburger icon when menu is closed
                        icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                    }
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuButton.contains(event.target) && !mobileNavigation.contains(event.target)) {
                    mobileNavigation.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            });

            // Close mobile menu on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !mobileNavigation.classList.contains('hidden')) {
                    mobileNavigation.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    mobileMenuButton.focus();
                }
            });
        }
    }

    /**
     * Initialize mobile submenu functionality
     */
    function initMobileSubmenu() {
        const mobileNavigation = document.getElementById('mobile-navigation');
        if (!mobileNavigation) return;

        // Find all parent menu items with submenus in mobile nav
        const parentItems = mobileNavigation.querySelectorAll('.menu-item-has-children');
        
        parentItems.forEach(function(parentItem) {
            const parentLink = parentItem.querySelector('a');
            const submenu = parentItem.querySelector('.sub-menu');
            
            if (parentLink && submenu) {
                // Add click event to parent link
                parentLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle the open class on parent item
                    parentItem.classList.toggle('open');
                    
                    // Toggle submenu visibility
                    if (parentItem.classList.contains('open')) {
                        submenu.style.display = 'block';
                        parentLink.setAttribute('aria-expanded', 'true');
                    } else {
                        submenu.style.display = 'none';
                        parentLink.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Set initial aria-expanded attribute
                parentLink.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /**
     * Initialize search toggle functionality
     */
    function initSearchToggle() {
        // Search UI removed from header

        // no-op
    }

    /**
     * Initialize smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement && targetId !== '#') {
                    event.preventDefault();
                    
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Update URL without triggering scroll
                    if (history.pushState) {
                        history.pushState(null, null, targetId);
                    }
                }
            });
        });
    }

    /**
     * Initialize focus management for accessibility
     */
    function initFocusManagement() {
        // Skip to content link
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(event) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    event.preventDefault();
                    targetElement.focus();
                    targetElement.scrollIntoView();
                }
            });
        }

        // Focus management for modal-like elements
        const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
        
        document.addEventListener('keydown', function(event) {
            // Trap focus in mobile menu when open
            const mobileNavigation = document.getElementById('mobile-navigation');
            if (mobileNavigation && !mobileNavigation.classList.contains('hidden')) {
                const focusableContent = mobileNavigation.querySelectorAll(focusableElements);
                const firstFocusableElement = focusableContent[0];
                const lastFocusableElement = focusableContent[focusableContent.length - 1];

                if (event.key === 'Tab') {
                    if (event.shiftKey) {
                        if (document.activeElement === firstFocusableElement) {
                            lastFocusableElement.focus();
                            event.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusableElement) {
                            firstFocusableElement.focus();
                            event.preventDefault();
                        }
                    }
                }
            }
        });
    }

    /**
     * Lazy load images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const lazyImages = document.querySelectorAll('img[data-src]');
            
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    // Initialize lazy loading if needed
    if (document.querySelectorAll('img[data-src]').length > 0) {
        initLazyLoading();
    }

})();
