/**
 * Premium Theme JavaScript
 * Enhances the premium user experience with smooth animations and interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // NAVBAR SCROLL EFFECTS
    // ========================================
    
    const navbar = document.querySelector('.premium-navbar');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add scrolled class for styling
        if (scrollTop > 50) {
            navbar?.classList.add('scrolled');
        } else {
            navbar?.classList.remove('scrolled');
        }
        
        // Hide/show navbar on scroll
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            navbar?.style.setProperty('transform', 'translateY(-100%)');
        } else {
            // Scrolling up
            navbar?.style.setProperty('transform', 'translateY(0)');
        }
        
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
    
    const searchInputs = document.querySelectorAll('.premium-form-input[type="search"], input[name="search"]');
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