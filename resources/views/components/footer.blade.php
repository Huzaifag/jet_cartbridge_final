<!-- Premium Footer -->
<footer class="premium-footer">
    <div class="premium-container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="premium-footer-brand mb-4">
                    <h4 class="text-white mb-2">Jet<span class="text-accent">Cartridge</span></h4>
                    <p class="premium-footer-text">Leading B2B marketplace connecting buyers with verified suppliers worldwide.</p>
                </div>
                <div class="premium-social-links">
                    <a href="#" class="premium-social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="premium-social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="premium-social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="premium-social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h5 class="premium-footer-title">Quick Links</h5>
                <ul class="premium-footer-links">
                    <li><a href="{{ route('categories') }}"><i class="fas fa-th-large me-2"></i>Product Categories</a></li>
                    <li><a href="{{ route('sellers') }}"><i class="fas fa-store me-2"></i>Verified Sellers</a></li>
                    <li><a href="{{ route('manufacturers') }}"><i class="fas fa-industry me-2"></i>Manufacturers</a></li>
                    <li><a href="{{ route('resources') }}"><i class="fas fa-book me-2"></i>Resources</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="premium-footer-title">Customer Service</h5>
                <ul class="premium-footer-links">
                    <li><a href="{{ route('faq') }}"><i class="fas fa-question-circle me-2"></i>Help Center</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-envelope me-2"></i>Contact Us</a></li>
                    <li><a href="#"><i class="fas fa-shield-alt me-2"></i>Report IPR</a></li>
                    <li><a href="{{ route('privacy') }}"><i class="fas fa-user-shield me-2"></i>Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="premium-footer-title">Legal</h5>
                <ul class="premium-footer-links">
                    <li><a href="{{ route('terms') }}"><i class="fas fa-file-contract me-2"></i>Terms of Service</a></li>
                    <li><a href="#"><i class="fas fa-handshake me-2"></i>Trade Assurance</a></li>
                    <li><a href="#"><i class="fas fa-id-card me-2"></i>Business Identity</a></li>
                    <li><a href="#"><i class="fas fa-chart-line me-2"></i>Production Monitoring</a></li>
                </ul>
            </div>
        </div>
        
        <div class="premium-footer-divider"></div>
        
        <div class="premium-footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="premium-footer-copyright">&copy; 2024 JetCartridge. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="premium-footer-badges">
                        <span class="footer-trust-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure</span>
                        </span>
                        <span class="footer-trust-badge">
                            <i class="fas fa-certificate"></i>
                            <span>Verified</span>
                        </span>
                        <span class="footer-trust-badge">
                            <i class="fas fa-globe"></i>
                            <span>Global</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Support Chat Button -->
<div class="support-chat-button" id="chatButton">
    <i class="fas fa-comments"></i>
    <span class="chat-badge">1</span>
</div>

<!-- Support Chat Popup -->
<div class="support-chat-popup" id="chatPopup">
    <div class="chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar">
                <i class="fas fa-headset"></i>
            </div>
            <div>
                <h5 class="chat-title">Customer Support</h5>
                <p class="chat-status"><span class="status-dot"></span>Online</p>
            </div>
        </div>
        <button class="chat-close" id="chatClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="chat-body">
        <div class="chat-message chat-message-received">
            <div class="message-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="message-content">
                <p>Hello! 👋 How can we help you today?</p>
                <span class="message-time">Just now</span>
            </div>
        </div>
        
        <div class="chat-quick-actions">
            <p class="quick-actions-title">Quick Actions:</p>
            <button class="quick-action-btn" onclick="sendQuickMessage('Track my order')">
                <i class="fas fa-shipping-fast"></i> Track Order
            </button>
            <button class="quick-action-btn" onclick="sendQuickMessage('Product inquiry')">
                <i class="fas fa-box"></i> Product Inquiry
            </button>
            <button class="quick-action-btn" onclick="sendQuickMessage('Bulk pricing')">
                <i class="fas fa-tags"></i> Bulk Pricing
            </button>
            <button class="quick-action-btn" onclick="sendQuickMessage('Technical support')">
                <i class="fas fa-tools"></i> Technical Support
            </button>
        </div>
    </div>
    
    <div class="chat-footer">
        <input type="text" class="chat-input" id="chatInput" placeholder="Type your message...">
        <button class="chat-send-btn" id="chatSend">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Support Chat Functionality
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatPopup = document.getElementById('chatPopup');
    const chatClose = document.getElementById('chatClose');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');
    const chatBody = chatPopup.querySelector('.chat-body');
    
    // Toggle chat popup
    chatButton.addEventListener('click', function() {
        chatPopup.classList.toggle('active');
        chatButton.classList.toggle('active');
        if (chatPopup.classList.contains('active')) {
            chatInput.focus();
            // Remove badge when opened
            const badge = chatButton.querySelector('.chat-badge');
            if (badge) badge.style.display = 'none';
        }
    });
    
    // Close chat
    chatClose.addEventListener('click', function() {
        chatPopup.classList.remove('active');
        chatButton.classList.remove('active');
    });
    
    // Send message
    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            addMessage(message, 'sent');
            chatInput.value = '';
            
            // Simulate response
            setTimeout(() => {
                addMessage('Thank you for your message! Our team will respond shortly.', 'received');
            }, 1000);
        }
    }
    
    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    // Add message to chat
    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message chat-message-${type}`;
        
        const time = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        
        if (type === 'received') {
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="message-content">
                    <p>${text}</p>
                    <span class="message-time">${time}</span>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-content">
                    <p>${text}</p>
                    <span class="message-time">${time}</span>
                </div>
            `;
        }
        
        chatBody.appendChild(messageDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    
    // Quick message function
    window.sendQuickMessage = function(message) {
        addMessage(message, 'sent');
        setTimeout(() => {
            addMessage('Thank you! A support agent will assist you with "' + message + '" shortly.', 'received');
        }, 1000);
    };
});
</script>