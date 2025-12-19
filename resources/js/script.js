// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Add to cart functionality
document.querySelectorAll('.btn-primary').forEach(button => {
    button.addEventListener('click', function() {
        const productName = this.parentElement.querySelector('.card-title').textContent;
        alert(`${productName} added to cart!`);
    });
});

// Form submission handling
const contactForm = document.querySelector('form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Thank you for your message! We will get back to you soon.');
        this.reset();
    });
}

// Premium Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.premium-navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// Add body padding class if premium top bar exists
document.addEventListener('DOMContentLoaded', function() {
    const topBar = document.querySelector('.premium-top-bar');
    if (topBar) {
        document.body.classList.add('has-premium-top-bar');
    }
});

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.hero-search-inline form');
    const searchInput = document.querySelector('.hero-search-input');
    
    if (searchForm && searchInput) {
        // Add search suggestions (optional enhancement)
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length > 2) {
                // You can add search suggestions here
                console.log('Searching for:', query);
            }
        });
        
        // Handle form submission
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            if (!query) {
                e.preventDefault();
                searchInput.focus();
                return false;
            }
            // Form will submit normally to the route
        });
        
        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
            
            // Escape to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.blur();
            }
        });
    }
});

// Add animation to product cards on scroll
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.product-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.5s ease-out';
    observer.observe(card);
}); 