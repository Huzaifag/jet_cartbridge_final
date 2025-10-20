@extends('seller.layouts.app')

@section('content')

    <style>
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .logo i {
            color: var(--secondary);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--gray);
            font-size: 16px;
            margin-bottom: 30px;
        }

        .settings-container {
            display: flex;
            gap: 25px;
        }

        .settings-sidebar {
            width: 250px;
            flex-shrink: 0;
        }

        .settings-content {
            flex-grow: 1;
        }

        .nav-pills {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .settings-nav-item {
            padding: 15px 3px;
            cursor: pointer;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .settings-nav-item:hover {
            background: var(--primary-light);
        }

        .settings-nav-item.active {
            background: var(--primary-light);
            border-left-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }

        .settings-nav-item i {
            width: 24px;
            margin-right: 10px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--light-gray);
            padding: 20px 25px;
            font-weight: 600;
            font-size: 18px;
            color: var(--primary-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        .card-body {
            padding: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 15px;
            background: white;
            cursor: pointer;
        }

        .last-updated {
            font-size: 14px;
            color: var(--gray);
            margin-top: 10px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary);
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .notification-group {
            margin-bottom: 25px;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            font-size: 16px;
        }

        .notification-options {
            display: flex;
            gap: 30px;
        }

        .notification-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-list {
            width: 100%;
            border-collapse: collapse;
        }

        .session-list th,
        .session-list td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        .session-list th {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .session-list tr:hover {
            background: var(--light);
        }

        .current-session {
            background: rgba(67, 97, 238, 0.05) !important;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .two-factor-setup {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-top: 20px;
        }

        .two-factor-options {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .two-factor-option {
            flex: 1;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius);
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .two-factor-option:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .two-factor-option.active {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .two-factor-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .settings-container {
                flex-direction: column;
            }

            .settings-sidebar {
                width: 100%;
            }

            .notification-options {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <div class="container">

        <div>
            <h1 class="page-title">Account Settings</h1>
            <p class="page-subtitle">Manage your payment methods, notifications, and security preferences</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul style="list-style: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="settings-container">
            <div class="settings-sidebar">
                <div class="nav-pills">
                    <div class="settings-nav-item active" data-target="payment-settings">
                        <i class="fas fa-credit-card"></i> Payment Settings
                    </div>
                    <div class="settings-nav-item" data-target="notification-preferences">
                        <i class="fas fa-bell"></i> Notification Preferences
                    </div>
                    <div class="settings-nav-item" data-target="security-settings">
                        <i class="fas fa-shield-alt"></i> Security Settings
                    </div>
                </div>
            </div>

            <div class="settings-content">
                <!-- Payment Settings -->
                <div class="card content-section" id="payment-settings">
                    <div class="card-header">
                        <span>Payment Settings</span>
                    </div>
                    <div class="card-body">
                        <form id="paymentForm" action="{{ route('seller.payment-settings.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="payoutMethod">Default Payout Method</label>
                                <select class="form-select" name="default_payout_method" id="payoutMethod">
                                    <option value="bank" {{ $paymentSetting->default_payout_method == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="upi" {{ $paymentSetting->default_payout_method == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="paypal" {{ $paymentSetting->default_payout_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                </select>
                            </div>

                            <div id="bankDetails" style="{{ $paymentSetting->default_payout_method == 'bank' ? 'display: block;' : 'display: none;' }}">
                                <div class="form-group">
                                    <label for="accountHolder">Account Holder Name</label>
                                    <input type="text" name="account_holder_name" class="form-control" id="accountHolder" value="{{ $paymentSetting->account_holder_name ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="bankName">Bank Name</label>
                                    <input name="bank_name" type="text" class="form-control" id="bankName" value="{{ $paymentSetting->bank_name ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="accountNumber">Account Number</label>
                                    <input name="account_number" type="text" class="form-control" id="accountNumber" value="{{ $paymentSetting->account_number ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="ifscCode">IFSC Code</label>
                                    <input name="ifsc_code" type="text" class="form-control" id="ifscCode" value="{{ $paymentSetting->ifsc_code ?? '' }}">
                                </div>
                            </div>

                            <div id="upiDetails" style="{{ $paymentSetting->default_payout_method == 'upi' ? 'display: block;' : 'display: none;' }}">
                                <div class="form-group">
                                    <label for="upiId">UPI ID</label>
                                    <input name="upi_id" type="text" class="form-control" id="upiId" value="{{ $paymentSetting->upi_id ?? '' }}" placeholder="yourname@upi">
                                </div>
                            </div>

                            <div id="paypalDetails" style="{{ $paymentSetting->default_payout_method == 'paypal' ? 'display: block;' : 'display: none;' }}">
                                <div class="form-group">
                                    <label for="paypalEmail">PayPal Email</label>
                                    <input name="paypal_email" type="email" class="form-control" id="paypalEmail" value="{{ $paymentSetting->paypal_email ?? '' }}" placeholder="your.email@example.com">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="savePaymentSettings">
                                <i class="fas fa-save"></i> Save Payment Settings
                            </button>

                            <div class="last-updated">
                                Last updated: July 15, 2023 at 14:30
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="card content-section" id="notification-preferences" style="display: none;">
                    <div class="card-header">
                        <span>Notification Preferences</span>
                    </div>
                    <div class="card-body">
                        <form id="notificationForm">
                            <div class="notification-group">
                                <h3 class="notification-title">Order Notifications</h3>
                                <div class="notification-options">
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="order_email" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Email</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="order_sms" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>SMS</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="order_push" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Push Notification</span>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-group">
                                <h3 class="notification-title">Inquiry Notifications</h3>
                                <div class="notification-options">
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="inquiry_email" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Email</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="inquiry_sms" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>SMS</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="inquiry_push" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Push Notification</span>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-group">
                                <h3 class="notification-title">Promotions/Offers Notifications</h3>
                                <div class="notification-options">
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="promotions_email" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Email</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="promotions_sms" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>SMS</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="promotions_push" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Push Notification</span>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-group">
                                <h3 class="notification-title">Payment Updates</h3>
                                <div class="notification-options">
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="payment_email" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Email</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="payment_sms" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>SMS</span>
                                    </div>
                                    <div class="notification-option">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="payment_push" checked>
                                            <span class="slider"></span>
                                        </label>
                                        <span>Push Notification</span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary" id="saveNotificationSettings">
                                <i class="fas fa-save"></i> Save Preferences
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="card content-section" id="security-settings" style="display: none;">
                    <div class="card-header">
                        <span>Security Settings</span>
                    </div>
                    <div class="card-body">
                        <form id="securityForm">
                            <h3>Change Password</h3>
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" name="currentPassword" class="form-control" id="currentPassword">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" name="newPassword" class="form-control" id="newPassword">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                            </div>
                            <button type="button" class="btn btn-primary" id="updatePassword">
                                <i class="fas fa-key"></i> Update Password
                            </button>

                            <div style="margin: 30px 0; border-top: 1px solid var(--light-gray);"></div>
                        </form>

                        <h3>Two-Factor Authentication</h3>
                        <form id="twoFactorForm" action="{{ route('seller.twofactor.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="notification-option">
                                    <label class="toggle-switch">
                                        <input type="checkbox" id="enable2FA" name="is_enabled" {{ $twoFactorSetting->is_enabled ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Enable Two-Factor Authentication</span>
                                </div>
                            </div>

                            <div class="two-factor-setup" id="twoFactorSetup" style="{{ $twoFactorSetting->is_enabled ? 'display: block;' : 'display: none;' }}">
                                <p>Select your preferred 2FA method:</p>
                                <div class="two-factor-options">
                                    <div class="two-factor-option {{ $twoFactorSetting->is_enabled && $twoFactorSetting->method == 'email' ? 'active' : '' }}" data-method="email">
                                        <div class="two-factor-icon"><i class="fas fa-envelope"></i></div>
                                        <div>Email OTP</div>
                                    </div>
                                    <div class="two-factor-option {{ $twoFactorSetting->is_enabled && $twoFactorSetting->method == 'sms' ? 'active' : '' }}" data-method="sms">
                                        <div class="two-factor-icon"><i class="fas fa-mobile-alt"></i></div>
                                        <div>SMS OTP</div>
                                    </div>
                                    <div class="two-factor-option {{ $twoFactorSetting->is_enabled && $twoFactorSetting->method == 'authenticator' ? 'active' : '' }}" data-method="authenticator">
                                        <div class="two-factor-icon"><i class="fas fa-mobile"></i></div>
                                        <div>Google Authenticator</div>
                                    </div>
                                </div>

                                <!-- Hidden input to hold selected method -->
                                <input type="hidden" name="method" id="twoFactorMethod" value="{{ $twoFactorSetting->method ?? '' }}">
                            </div>

                            <button type="button" class="btn btn-primary mt-3" id="saveTwoFactorSettings">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.settings-nav-item');
            const contentSections = document.querySelectorAll('.content-section');
            const payoutMethod = document.getElementById('payoutMethod');
            const bankDetails = document.getElementById('bankDetails');
            const upiDetails = document.getElementById('upiDetails');
            const paypalDetails = document.getElementById('paypalDetails');
            const enable2FA = document.getElementById('enable2FA');
            const twoFactorSetup = document.getElementById('twoFactorSetup');
            const options = document.querySelectorAll('.two-factor-option');
            const hiddenInput = document.getElementById('twoFactorMethod');

            // Navigation between settings sections
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    navItems.forEach(navItem => navItem.classList.remove('active'));
                    this.classList.add('active');
                    contentSections.forEach(section => section.style.display = 'none');
                    document.getElementById(target).style.display = 'block';
                });
            });

            // Show/hide payment method details based on selection
            payoutMethod.addEventListener('change', function() {
                bankDetails.style.display = 'none';
                upiDetails.style.display = 'none';
                paypalDetails.style.display = 'none';
                if (this.value === 'bank') {
                    bankDetails.style.display = 'block';
                } else if (this.value === 'upi') {
                    upiDetails.style.display = 'block';
                } else if (this.value === 'paypal') {
                    paypalDetails.style.display = 'block';
                }
            });

            // Initialize payment method visibility
            if (payoutMethod.value === 'bank') {
                bankDetails.style.display = 'block';
            } else if (payoutMethod.value === 'upi') {
                upiDetails.style.display = 'block';
            } else if (payoutMethod.value === 'paypal') {
                paypalDetails.style.display = 'block';
            }

            // Show/hide 2FA setup options and handle method selection
            enable2FA.addEventListener('change', function() {
                twoFactorSetup.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    hiddenInput.value = '';
                    options.forEach(opt => opt.classList.remove('active'));
                }
            });

            // Handle 2FA method selection
            options.forEach(option => {
                option.addEventListener('click', function() {
                    if (enable2FA.checked) {
                        options.forEach(opt => opt.classList.remove('active'));
                        this.classList.add('active');
                        hiddenInput.value = this.dataset.method;
                    }
                });
            });

            // Save notification settings
            document.getElementById('saveNotificationSettings').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('notificationForm'));
                Swal.fire({
                    title: 'Saving...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        fetch("{{ route('seller.notification-preferences.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 302 || response.redirected) {
                                    throw new Error('Redirect detected. Please ensure you are logged in.');
                                }
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: data.success ? 'success' : 'error',
                                title: data.success ? 'Success' : 'Error',
                                text: data.message,
                                timer: data.success ? 2000 : undefined,
                                showConfirmButton: !data.success
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'An error occurred while saving the settings. Please try again.'
                            });
                        });
                    }
                });
            });

            // Load notification preferences
            fetch("{{ route('seller.notification-preferences.show') }}", {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load notification preferences');
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    for (const key in data) {
                        const checkbox = document.querySelector(`input[name="${key}"]`);
                        if (checkbox) {
                            checkbox.checked = data[key] === 1;
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading notification preferences:', error));

            // Save two-factor settings
            document.getElementById('saveTwoFactorSettings').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('twoFactorForm'));
                // Ensure is_enabled is sent as boolean
                formData.set('is_enabled', enable2FA.checked ? '1' : '0');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('seller.twofactor.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 302 || response.redirected) {
                                    throw new Error('Redirect detected. Please ensure you are logged in.');
                                }
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: data.success ? 'success' : 'error',
                                title: data.success ? 'Saved!' : 'Error',
                                text: data.message,
                                timer: data.success ? 2000 : undefined,
                                showConfirmButton: !data.success
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'An error occurred while saving the settings.'
                            });
                        });
                    }
                });
            });

            // Change Password
            document.getElementById('updatePassword').addEventListener('click', function() {
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New password and confirm password do not match.'
                    });
                    return;
                }

                fetch("{{ route('seller.change-password') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        new_password_confirmation: confirmPassword
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 302 || response.redirected) {
                            throw new Error('Redirect detected. Please ensure you are logged in.');
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: data.success ? 'success' : 'error',
                        title: data.success ? 'Success!' : 'Error',
                        text: data.message,
                        timer: data.success ? 2000 : undefined,
                        showConfirmButton: !data.success
                    }).then(() => {
                        if (data.success) {
                            document.getElementById('securityForm').reset();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Server error, try again later.'
                    });
                });
            });
        });
    </script>
@endsection