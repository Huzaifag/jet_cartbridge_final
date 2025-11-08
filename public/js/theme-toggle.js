/**
 * Premium Theme Toggle System
 * Dark/Light Mode Functionality for B2B Marketplace
 */

class ThemeToggle {
    constructor() {
        this.currentTheme = this.getStoredTheme() || this.getPreferredTheme();
        this.init();
    }

    init() {
        // Set initial theme
        this.setTheme(this.currentTheme);
        
        // Create toggle button
        this.createToggleButton();
        
        // Listen for system theme changes
        this.watchSystemTheme();
        
        // Add keyboard shortcut (Ctrl/Cmd + Shift + T)
        this.addKeyboardShortcut();
    }

    getStoredTheme() {
        return localStorage.getItem('theme');
    }

    getPreferredTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    setTheme(theme) {
        this.currentTheme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Update toggle button
        this.updateToggleButton();
        
        // Dispatch custom event
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
        
        // Add smooth transition class
        document.body.classList.add('theme-transitioning');
        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 300);
    }

    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
        
        // Add ripple effect to toggle button
        this.addRippleEffect();
    }

    createToggleButton() {
        // Find existing toggle button in HTML
        const toggleButton = document.getElementById('themeToggleBtn');
        if (toggleButton) {
            // Add click event to existing button
            toggleButton.addEventListener('click', () => this.toggleTheme());
        }
    }

    updateToggleButton() {
        const toggleBtn = document.getElementById('themeToggleBtn');
        if (toggleBtn) {
            toggleBtn.classList.toggle('dark-mode', this.currentTheme === 'dark');
            toggleBtn.setAttribute('aria-label', 
                `Switch to ${this.currentTheme === 'dark' ? 'light' : 'dark'} theme`
            );
        }
    }

    addRippleEffect() {
        const toggleBtn = document.getElementById('themeToggleBtn');
        if (!toggleBtn) return;

        const ripple = document.createElement('span');
        ripple.className = 'theme-toggle-ripple';
        toggleBtn.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    watchSystemTheme() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                // Only auto-switch if user hasn't manually set a preference
                if (!localStorage.getItem('theme')) {
                    this.setTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }

    addKeyboardShortcut() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+Shift+T or Cmd+Shift+T
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                e.preventDefault();
                this.toggleTheme();
                
                // Show toast notification
                this.showThemeToast();
            }
        });
    }

    showThemeToast() {
        // Remove existing toast
        const existingToast = document.querySelector('.theme-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast
        const toast = document.createElement('div');
        toast.className = 'theme-toast';
        toast.innerHTML = `
            <i class="fas fa-${this.currentTheme === 'dark' ? 'moon' : 'sun'} me-2"></i>
            Switched to ${this.currentTheme} theme
        `;

        // Add to page
        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => toast.classList.add('show'), 100);

        // Hide and remove toast
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    // Public method to get current theme
    getCurrentTheme() {
        return this.currentTheme;
    }

    // Public method to set theme programmatically
    setThemeManually(theme) {
        if (theme === 'dark' || theme === 'light') {
            this.setTheme(theme);
        }
    }
}

// Initialize theme toggle when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.themeToggle = new ThemeToggle();
});

// Add CSS for theme toggle
const themeToggleCSS = `
/* Theme Toggle Button Styles */
.theme-toggle-container {
    margin: 0 0.75rem;
    display: flex;
    align-items: center;
}

.theme-toggle-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    border-radius: 50px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.theme-toggle-track {
    width: 50px;
    height: 24px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.theme-toggle-thumb {
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border-radius: 50%;
    position: absolute;
    top: 2px;
    left: 2px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.theme-icon-sun,
.theme-icon-moon {
    position: absolute;
    font-size: 10px;
    transition: all 0.3s ease;
    color: #ffffff;
}

.theme-icon-sun {
    opacity: 1;
    transform: scale(1);
}

.theme-icon-moon {
    opacity: 0;
    transform: scale(0.5);
}

/* Dark mode state */
.theme-toggle-btn.dark-mode .theme-toggle-thumb {
    transform: translateX(26px);
}

.theme-toggle-btn.dark-mode .theme-icon-sun {
    opacity: 0;
    transform: scale(0.5);
}

.theme-toggle-btn.dark-mode .theme-icon-moon {
    opacity: 1;
    transform: scale(1);
}

/* Hover effects */
.theme-toggle-btn:hover .theme-toggle-track {
    background: rgba(245, 158, 11, 0.1);
    border-color: rgba(245, 158, 11, 0.4);
}

.theme-toggle-btn:hover .theme-toggle-thumb {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.theme-toggle-btn.dark-mode:hover .theme-toggle-thumb {
    transform: translateX(26px) scale(1.1);
}

/* Ripple effect */
.theme-toggle-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(245, 158, 11, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    margin-top: -30px;
    margin-left: -30px;
}

@keyframes ripple-animation {
    to {
        transform: scale(2);
        opacity: 0;
    }
}

/* Theme transition */
.theme-transitioning * {
    transition: background-color 0.3s ease, 
                color 0.3s ease, 
                border-color 0.3s ease, 
                box-shadow 0.3s ease !important;
}

/* Theme toast notification */
.theme-toast {
    position: fixed;
    top: 100px;
    right: 20px;
    background: var(--color-accent);
    color: #ffffff;
    padding: 12px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    z-index: 10000;
    transform: translateX(100%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex;
    align-items: center;
}

.theme-toast.show {
    transform: translateX(0);
    opacity: 1;
}

/* Light theme adjustments for toggle */
[data-theme="light"] .theme-toggle-track {
    background: rgba(0, 0, 0, 0.1);
    border-color: rgba(245, 158, 11, 0.3);
}

[data-theme="light"] .theme-toggle-btn:hover .theme-toggle-track {
    background: rgba(245, 158, 11, 0.08);
    border-color: rgba(245, 158, 11, 0.5);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .theme-toggle-container {
        margin: 0 0.5rem;
    }
    
    .theme-toggle-track {
        width: 44px;
        height: 22px;
    }
    
    .theme-toggle-thumb {
        width: 18px;
        height: 18px;
    }
    
    .theme-toggle-btn.dark-mode .theme-toggle-thumb {
        transform: translateX(22px);
    }
    
    .theme-toggle-btn.dark-mode:hover .theme-toggle-thumb {
        transform: translateX(22px) scale(1.1);
    }
    
    .theme-toast {
        right: 10px;
        top: 80px;
        font-size: 13px;
        padding: 10px 16px;
    }
}
`;

// Inject CSS
const themeToggleStyle = document.createElement('style');
themeToggleStyle.textContent = themeToggleCSS;
document.head.appendChild(themeToggleStyle);

// ========================================
// THEME TOGGLE ENHANCEMENTS
// ========================================

// Add theme-aware image loading
document.addEventListener('themeChanged', (e) => {
    const theme = e.detail.theme;
    
    // Update images that have theme variants
    const themeImages = document.querySelectorAll('[data-theme-src]');
    themeImages.forEach(img => {
        const lightSrc = img.getAttribute('data-light-src');
        const darkSrc = img.getAttribute('data-dark-src');
        
        if (theme === 'light' && lightSrc) {
            img.src = lightSrc;
        } else if (theme === 'dark' && darkSrc) {
            img.src = darkSrc;
        }
    });
    
    // Update favicon based on theme
    updateFavicon(theme);
    
    // Update meta theme color
    updateMetaThemeColor(theme);
});

function updateFavicon(theme) {
    const favicon = document.querySelector('link[rel="icon"]') || 
                   document.querySelector('link[rel="shortcut icon"]');
    
    if (favicon) {
        const basePath = favicon.href.replace(/\/[^\/]*$/, '/');
        favicon.href = `${basePath}favicon-${theme}.ico`;
    }
}

function updateMetaThemeColor(theme) {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    
    if (!metaThemeColor) {
        metaThemeColor = document.createElement('meta');
        metaThemeColor.name = 'theme-color';
        document.head.appendChild(metaThemeColor);
    }
    
    metaThemeColor.content = theme === 'dark' ? '#0d0d1e' : '#ffffff';
}

// Add smooth scroll behavior for theme changes
document.addEventListener('themeChanged', () => {
    // Smooth scroll to top if user is far down the page
    if (window.scrollY > 100) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
});

// Add theme persistence across page navigation
window.addEventListener('beforeunload', () => {
    // Ensure theme is saved before page unload
    if (window.themeToggle) {
        localStorage.setItem('theme', window.themeToggle.getCurrentTheme());
    }
});

// Add theme analytics (optional)
document.addEventListener('themeChanged', (e) => {
    // Track theme changes for analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'theme_change', {
            'theme': e.detail.theme,
            'method': 'toggle_button'
        });
    }
    
    // Console log for development
    console.log(`🎨 Theme switched to: ${e.detail.theme}`);
});

// Add automatic theme switching based on time of day (optional feature)
function enableAutoThemeSwitch() {
    const hour = new Date().getHours();
    const isDayTime = hour >= 6 && hour < 18;
    
    // Only auto-switch if user hasn't manually set preference
    if (!localStorage.getItem('theme')) {
        const autoTheme = isDayTime ? 'light' : 'dark';
        if (window.themeToggle) {
            window.themeToggle.setThemeManually(autoTheme);
        }
    }
}

// Uncomment to enable auto theme switching
// enableAutoThemeSwitch();