<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // Mark notifications as read when dropdown is opened
        const notificationDropdown = document.getElementById('notificationDropdown');
        if (notificationDropdown) {
            notificationDropdown.addEventListener('shown.bs.dropdown', function () {
                const badge = this.querySelector('.badge');
                if (badge) {
                    badge.style.display = 'none';
                }
            });
        }

        // Mark messages as read when dropdown is opened
        const messagesDropdown = document.getElementById('messagesDropdown');
        if (messagesDropdown) {
            messagesDropdown.addEventListener('shown.bs.dropdown', function () {
                const badge = this.querySelector('.badge');
                if (badge) {
                    badge.style.display = 'none';
                }
            });
        }

        // Accept Meeting
        document.querySelectorAll('.accept-meeting').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`/seller/meeting/${id}/accept`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Failed to accept meeting');
                    }
                });
            });
        });

        // Reject Meeting
        document.querySelectorAll('.reject-meeting').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`/seller/meeting/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Meeting rejected');
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to reject meeting');
                    }
                });
            });
        });

        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert && alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 150);
                }
            }, 5000);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Add loading state to buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                    
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 5000);
                }
            });
        });
    });

    // Global functions
    window.showAlert = function(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        const container = document.querySelector('.content-wrapper');
        if (container) {
            container.insertAdjacentHTML('afterbegin', alertHtml);
        }
    };

    window.confirmDelete = function(message = 'Are you sure you want to delete this item?') {
        return Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        });
    };

    // Chart.js default configuration
    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = 'Poppins';
        Chart.defaults.color = '#858796';
    }
</script>