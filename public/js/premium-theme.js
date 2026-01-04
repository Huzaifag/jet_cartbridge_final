/**
 * Premium Theme JavaScript
 * Enhances the premium user experience with smooth animations and interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // NAVBAR SCROLL EFFECTS & FIXED POSITIONING
    // ========================================
    
    const navbar = document.querySelector('.premium-navbar');
    const topBar = document.querySelector('.premium-top-bar');
    let lastScrollTop = 0;
    
    // Add body padding class if premium top bar exists
    if (topBar) {
        document.body.classList.add('has-premium-top-bar');
    }
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add scrolled class for styling
        if (scrollTop > 50) {
            navbar?.classList.add('scrolled');
        } else {
            navbar?.classList.remove('scrolled');
        }
        
        // For fixed navbar, we don't hide it on scroll - keep it always visible
        // Remove the hide/show behavior for better UX with fixed positioning
        
        lastScrollTop = scrollTop;
    });
    
    // ========================================
    // INTERSECTION OBSERVER FOR ANIMATIONS
    // ========================================
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                // Add staggered animation for grid items
                if (entry.target.parentElement?.classList.contains('premium-grid')) {
                    const siblings = Array.from(entry.target.parentElement.children);
                    const index = siblings.indexOf(entry.target);
                    entry.target.style.animationDelay = `${index * 0.1}s`;
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all premium animation elements
    const animatedElements = document.querySelectorAll('.premium-fade-in, .premium-slide-up, .premium-scale-in');
    animatedElements.forEach(el => {
        // Set initial state
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1)';
        
        observer.observe(el);
    });
    
    // ========================================
    // PREMIUM CARD HOVER EFFECTS
    // ========================================
    
    const premiumCards = document.querySelectorAll('.premium-card');
    premiumCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // ========================================
    // PREMIUM BUTTON RIPPLE EFFECT
    // ========================================
    
    const premiumButtons = document.querySelectorAll('.btn-premium');
    premiumButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // ========================================
    // SMOOTH SCROLLING FOR ANCHOR LINKS
    // ========================================
    
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ========================================
    // PREMIUM LOADING STATES
    // ========================================
    
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                const originalText = submitBtn.textContent || submitBtn.value;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 5000);
            }
        });
    });
    
    // ========================================
    // PREMIUM TOOLTIPS
    // ========================================
    
    const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        tooltipElements.forEach(el => {
            new bootstrap.Tooltip(el, {
                customClass: 'premium-tooltip'
            });
        });
    }
    
    // ========================================
    // PREMIUM DROPDOWN FIX
    // ========================================
    
    // Ensure Bootstrap dropdowns work properly
    const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
        dropdownElements.forEach(el => {
            new bootstrap.Dropdown(el, {
                autoClose: true,
                boundary: 'viewport'
            });
        });
    }
    
    // Fix dropdown positioning
    document.addEventListener('shown.bs.dropdown', function (e) {
        const dropdown = e.target.nextElementSibling;
        if (dropdown && dropdown.classList.contains('premium-user-dropdown')) {
            // Ensure dropdown is properly positioned
            dropdown.style.transform = 'translate3d(0, 0, 0)';
        }
    });
    
    // ========================================
    // PREMIUM SEARCH ENHANCEMENTS
    // ========================================
    
    const searchInputs = document.querySelectorAll('.premium-form-input[type="search"], input[name="search"], .hero-search-input');
    const searchForm = document.querySelector('.hero-search-inline form');
    const searchInput = document.querySelector('.hero-search-input');
    
    // Enhanced search functionality
    searchInputs.forEach(input => {
        let searchTimeout;
        
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();
            
            if (searchTerm.length > 2) {
                searchTimeout = setTimeout(() => {
                    // Add search suggestions or live search here
                    console.log('Searching for:', searchTerm);
                }, 300);
            }
        });
    });
    
    // Handle search form submission
    if (searchForm && searchInput) {
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            if (!query) {
                e.preventDefault();
                searchInput.focus();
                // Add visual feedback for empty search
                searchInput.style.borderColor = '#ef4444';
                setTimeout(() => {
                    searchInput.style.borderColor = '';
                }, 1000);
                return false;
            }
            // Form will submit normally to the route
        });
        
        // Add keyboard shortcuts for search
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
            
            // Escape to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.blur();
            }
        });
        
        // Add search input focus effects
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
    
    // ========================================
    // PREMIUM CART BADGE ANIMATION
    // ========================================
    
    const cartBadge = document.querySelector('.premium-badge');
    if (cartBadge) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    cartBadge.style.animation = 'none';
                    cartBadge.offsetHeight; // Trigger reflow
                    cartBadge.style.animation = 'pulse 0.5s ease-in-out';
                }
            });
        });
        
        observer.observe(cartBadge, {
            childList: true,
            characterData: true,
            subtree: true
        });
    }
    
    // ========================================
    // PREMIUM PERFORMANCE OPTIMIZATIONS
    // ========================================
    
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Preload critical resources
    const criticalResources = [
        '/css/premium-theme.css',
        '/images/logo/logo.png'
    ];
    
    criticalResources.forEach(resource => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.href = resource;
        link.as = resource.endsWith('.css') ? 'style' : 'image';
        document.head.appendChild(link);
    });
});

// ========================================
// CSS ANIMATIONS FOR RIPPLE EFFECT
// ========================================

const style = document.createElement('style');
style.textContent = `
    .btn-premium {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .premium-tooltip .tooltip-inner {
        background: var(--color-dark-navy);
        color: var(--color-white);
        border: 1px solid var(--color-accent);
        border-radius: 0.5rem;
        font-weight: 500;
    }
    
    .premium-tooltip .tooltip-arrow::before {
        border-top-color: var(--color-accent);
    }
`;

document.head.appendChild(style); 
   // ========================================
    // NEAREST SELLERS FUNCTIONALITY
    // ========================================
    
    // Add nearest sellers functionality to global scope
    window.findNearestSellers = function() {
        const btn = document.getElementById('nearestSellerBtn');
        if (!btn) return;
        
        const originalContent = btn.innerHTML;
        
        // Show loading state
        btn.classList.add('loading');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i><span>Locating...</span>';
        btn.disabled = true;
        
        // Check if geolocation is supported
        if (!navigator.geolocation) {
            showLocationError('Geolocation is not supported by this browser.');
            resetButton();
            return;
        }
        
        // Request user location
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Redirect to sellers page with location parameters
                const url = new URL('/sellers', window.location.origin);
                url.searchParams.set('nearest', '1');
                url.searchParams.set('user_lat', lat);
                url.searchParams.set('user_lng', lng);
                url.searchParams.set('radius', '25');
                
                window.location.href = url.toString();
            },
            function(error) {
                let errorMessage = 'Unable to retrieve your location.';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Location access denied. Please enable location services and try again.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Location request timed out.';
                        break;
                    default:
                        errorMessage = 'An unknown error occurred while retrieving your location.';
                        break;
                }
                
                showLocationError(errorMessage);
                resetButton();
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutes
            }
        );
        
        function resetButton() {
            if (btn) {
                btn.classList.remove('loading');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        }
    };
    
    // Show location error modal
    function showLocationError(message) {
        // Remove existing modal if any
        const existingModal = document.querySelector('.location-modal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'location-modal';
        
        // Create the modal content structure
        const modalContent = document.createElement('div');
        modalContent.className = 'location-modal-content';
        
        // Create header
        const header = document.createElement('h4');
        header.innerHTML = '<i class="fas fa-exclamation-triangle text-warning me-2"></i>Location Access';
        
        // Create description
        const description = document.createElement('p');
        description.textContent = message;
        
        // Create buttons container
        const buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'location-modal-buttons';
        
        // Create buttons
        const cancelBtn = document.createElement('button');
        cancelBtn.className = 'location-modal-btn secondary';
        cancelBtn.textContent = 'Cancel';
        cancelBtn.onclick = closeLocationModal;
        
        const retryBtn = document.createElement('button');
        retryBtn.className = 'location-modal-btn primary';
        retryBtn.textContent = 'Try Again';
        retryBtn.onclick = retryLocation;
        
        // Assemble the modal
        buttonsContainer.appendChild(cancelBtn);
        buttonsContainer.appendChild(retryBtn);
        
        modalContent.appendChild(header);
        modalContent.appendChild(description);
        modalContent.appendChild(buttonsContainer);
        
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        
        // Prevent body scroll
        document.body.classList.add('modal-open');
        
        // Show modal with animation
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        
        // Auto close after 5 seconds
        setTimeout(() => {
            closeLocationModal();
        }, 5000);
    }
    
    // Close location modal
    window.closeLocationModal = function() {
        const modal = document.querySelector('.location-modal');
        if (modal) {
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    };
    
    // Retry location
    window.retryLocation = function() {
        try {
            closeLocationModal();
            setTimeout(() => {
                findNearestSellers();
            }, 300); // Small delay to ensure modal is closed
        } catch (error) {
            console.error('Error retrying location:', error);
            closeLocationModal();
        }
    };
    
    // Add click outside to close modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('location-modal')) {
            closeLocationModal();
        }
    });
    
    // ========================================
    // LOCATION PERMISSION PROMPT
    // ========================================
    
    // Show location permission prompt on first visit
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user has already been prompted
        const hasBeenPrompted = localStorage.getItem('locationPrompted');
        
        // if (!hasBeenPrompted && navigator.geolocation) {
        //     // Show subtle notification about location features
        //     setTimeout(() => {
        //         showLocationPrompt();
        //     }, 3000); // Show after 3 seconds
        // }
    });
    
    // function showLocationPrompt() {
    //     const modal = document.createElement('div');
    //     modal.className = 'location-modal';
        
    //     // Create the modal content structure
    //     const modalContent = document.createElement('div');
    //     modalContent.className = 'location-modal-content';
        
    //     // Create header
    //     const header = document.createElement('h4');
    //     header.innerHTML = '<i class="fas fa-map-marker-alt text-accent me-2"></i>Find Nearby Sellers';
        
    //     // Create description
    //     const description = document.createElement('p');
    //     description.textContent = 'Allow location access to discover sellers and products near you for faster delivery and better service.';
        
    //     // Create buttons container
    //     const buttonsContainer = document.createElement('div');
    //     buttonsContainer.className = 'location-modal-buttons';
        
    //     // Create buttons
    //     const declineBtn = document.createElement('button');
    //     declineBtn.className = 'location-modal-btn secondary';
    //     declineBtn.textContent = 'Maybe Later';
    //     declineBtn.onclick = declineLocation;
        
    //     const allowBtn = document.createElement('button');
    //     allowBtn.className = 'location-modal-btn primary';
    //     allowBtn.textContent = 'Allow Location';
    //     allowBtn.onclick = allowLocation;
        
    //     // Assemble the modal
    //     buttonsContainer.appendChild(declineBtn);
    //     buttonsContainer.appendChild(allowBtn);
        
    //     modalContent.appendChild(header);
    //     modalContent.appendChild(description);
    //     modalContent.appendChild(buttonsContainer);
        
    //     modal.appendChild(modalContent);
    //     document.body.appendChild(modal);
        
    //     // Prevent body scroll
    //     document.body.classList.add('modal-open');
        
    //     // Show modal with animation
    //     setTimeout(() => {
    //         modal.classList.add('show');
    //     }, 10);
    // }
    
    window.allowLocation = function() {
        try {
            localStorage.setItem('locationPrompted', 'true');
            closeLocationModal();
            findNearestSellers();
        } catch (error) {
            console.error('Error allowing location:', error);
            closeLocationModal();
        }
    };
    
    window.declineLocation = function() {
        try {
            localStorage.setItem('locationPrompted', 'true');
            closeLocationModal();
        } catch (error) {
            console.error('Error declining location:', error);
            closeLocationModal();
        }
    };
    
    // ========================================
    // COLLAPSIBLE FILTERS FUNCTIONALITY
    // ========================================
    
    // Initialize filter toggle functionality
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filtersCollapse = document.getElementById('filtersCollapse');
    const filtersColumn = document.querySelector('.col-lg-3');
    const productsColumn = document.getElementById('productsColumn');
    
    if (filterToggleBtn && filtersCollapse) {
        // Set initial state - filters are collapsed by default
        filterToggleBtn.classList.add('collapsed');
        
        // Update button text and icon based on collapse state
        filtersCollapse.addEventListener('show.bs.collapse', function () {
            const btnText = filterToggleBtn.querySelector('.filter-btn-text');
            if (btnText) {
                btnText.textContent = 'Hide Filters';
            }
            filterToggleBtn.classList.remove('collapsed');
            
            // Adjust layout - show filters column
            if (filtersColumn) {
                filtersColumn.classList.remove('filters-column-hidden');
            }
            if (productsColumn) {
                productsColumn.classList.remove('products-full-width');
                productsColumn.className = productsColumn.className.replace(/col-\w+-\d+/g, '');
                productsColumn.classList.add('col-lg-9');
            }
        });
        
        filtersCollapse.addEventListener('hide.bs.collapse', function () {
            const btnText = filterToggleBtn.querySelector('.filter-btn-text');
            if (btnText) {
                btnText.textContent = 'Show Filters';
            }
            filterToggleBtn.classList.add('collapsed');
            
            // Adjust layout - hide filters column and expand products
            if (filtersColumn) {
                filtersColumn.classList.add('filters-column-hidden');
            }
            if (productsColumn) {
                productsColumn.classList.add('products-full-width');
                productsColumn.className = productsColumn.className.replace(/col-\w+-\d+/g, '');
                productsColumn.classList.add('col-12');
            }
        });
        
        // Set initial layout state (filters hidden)
        if (filtersColumn) {
            filtersColumn.classList.add('filters-column-hidden');
        }
        if (productsColumn) {
            productsColumn.classList.add('products-full-width');
            productsColumn.className = productsColumn.className.replace(/col-\w+-\d+/g, '');
            productsColumn.classList.add('col-12');
        }
        
        // Add active filters counter
        updateActiveFiltersCount();
        
        // Listen for form changes to update counter
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('change', function() {
                setTimeout(updateActiveFiltersCount, 100);
            });
        }
    }
    
    // Function to count and display active filters
    function updateActiveFiltersCount() {
        const filterToggleBtn = document.getElementById('filterToggleBtn');
        if (!filterToggleBtn) return;
        
        let activeCount = 0;
        
        // Count active filters from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const filterParams = ['price', 'rating', 'seller_type', 'location', 'category'];
        
        filterParams.forEach(param => {
            if (urlParams.has(param) && urlParams.get(param) !== '') {
                if (param === 'seller_type' || param === 'location') {
                    // Count array parameters
                    const values = urlParams.getAll(param + '[]');
                    activeCount += values.length;
                } else {
                    activeCount++;
                }
            }
        });
        
        // Remove existing badge
        const existingBadge = filterToggleBtn.querySelector('.active-filters-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        // Add badge if there are active filters
        if (activeCount > 0) {
            const badge = document.createElement('span');
            badge.className = 'active-filters-badge';
            badge.textContent = activeCount;
            filterToggleBtn.style.position = 'relative';
            filterToggleBtn.appendChild(badge);
            filterToggleBtn.classList.add('has-active-filters');
        } else {
            filterToggleBtn.classList.remove('has-active-filters');
        }
    }
    
    // ========================================
    // FILTER FORM ENHANCEMENTS
    // ========================================
    
    // Add loading state to filter form submissions
    const filterSelects = document.querySelectorAll('#filter-form select, #filter-form input[type="checkbox"], #filter-form input[type="radio"]');
    filterSelects.forEach(element => {
        element.addEventListener('change', function() {
            // Add loading state
            const form = this.closest('form');
            if (form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.textContent;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Applying...';
                    
                    // Reset after form submission
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }, 2000);
                }
            }
        });
    });
    
    // ========================================
    // FILTER PERSISTENCE
    // ========================================
    
    // Save filter state to localStorage
    function saveFilterState() {
        const filterState = {};
        const form = document.getElementById('filter-form');
        if (form) {
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                if (filterState[key]) {
                    if (Array.isArray(filterState[key])) {
                        filterState[key].push(value);
                    } else {
                        filterState[key] = [filterState[key], value];
                    }
                } else {
                    filterState[key] = value;
                }
            }
            localStorage.setItem('productFilters', JSON.stringify(filterState));
        }
    }
    
    // Auto-save filters on change
    const filterInputs = document.querySelectorAll('#filter-form input, #filter-form select');
    filterInputs.forEach(input => {
        input.addEventListener('change', saveFilterState);
    });
    
    // ========================================
    // FILTER ANIMATIONS
    // ========================================
    
    // Add smooth animations to filter sections
    const filterSections = document.querySelectorAll('.filter-section');
    filterSections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
        section.classList.add('premium-fade-in');
    });
    
    // Highlight active filters
    function highlightActiveFilters() {
        const activeInputs = document.querySelectorAll('#filter-form input:checked, #filter-form select:not([value=""])');
        activeInputs.forEach(input => {
            const parent = input.closest('.mb-3') || input.closest('.form-check');
            if (parent) {
                parent.classList.add('filter-active');
            }
        });
    }
    
    // Initialize filter highlighting
    highlightActiveFilters();
    
    // ========================================
    // FILTER KEYBOARD SHORTCUTS
    // ========================================
    
    // Add keyboard shortcut to toggle filters (F key)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'f' || e.key === 'F') {
            // Only if not typing in an input
            if (!['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
                e.preventDefault();
                if (filterToggleBtn) {
                    filterToggleBtn.click();
                }
            }
        }
    });