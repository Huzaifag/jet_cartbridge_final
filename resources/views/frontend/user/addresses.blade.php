<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Addresses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e1e5eb;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #4e54c8;
        }
        
        .user-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #4e54c8;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: #3a3fb8;
        }
        
        .btn-outline {
            background: transparent;
            color: #4e54c8;
            border: 1px solid #4e54c8;
        }
        
        .btn-outline:hover {
            background: #f0f2ff;
        }
        
        .page-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #2d3748;
        }
        
        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .address-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        
        .address-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }
        
        .address-card.default {
            border: 2px solid #4e54c8;
        }
        
        .default-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #4e54c8;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .address-type {
            font-weight: 600;
            color: #4e54c8;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .address-details {
            margin-bottom: 20px;
            color: #4a5568;
        }
        
        .address-actions {
            display: flex;
            gap: 12px;
            border-top: 1px solid #e1e5eb;
            padding-top: 15px;
        }
        
        .action-btn {
            background: none;
            border: none;
            color: #718096;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }
        
        .action-btn:hover {
            color: #4e54c8;
        }
        
        .add-address-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px dashed #cbd5e0;
        }
        
        .add-address-card:hover {
            border-color: #4e54c8;
            background: #f8faff;
        }
        
        .add-icon {
            font-size: 40px;
            color: #4e54c8;
            margin-bottom: 15px;
        }
        
        .add-text {
            font-weight: 600;
            color: #4e54c8;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .modal-title {
            font-size: 22px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #718096;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e1e5eb;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus, select:focus {
            border-color: #4e54c8;
            outline: none;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }
        
        .checkbox-group input {
            width: auto;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .address-grid {
                grid-template-columns: 1fr;
            }
            
            .user-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">ShopEasy</div>
            <div class="user-actions">
                <a href="#" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Profile</a>
                <a href="#" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Continue Shopping</a>
            </div>
        </header>
        
        <h1 class="page-title">Manage Your Addresses</h1>
        
        <div class="address-grid">
            <div class="address-card default">
                <span class="default-badge">Default</span>
                <div class="address-type">
                    <i class="fas fa-home"></i> Home Address
                </div>
                <div class="address-details">
                    <p>John Doe</p>
                    <p>123 Main Street, Apt 4B</p>
                    <p>New York, NY 10001</p>
                    <p>United States</p>
                    <p><strong>Phone:</strong> (555) 123-4567</p>
                </div>
                <div class="address-actions">
                    <button class="action-btn"><i class="fas fa-edit"></i> Edit</button>
                    <button class="action-btn"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
            
            <div class="address-card">
                <div class="address-type">
                    <i class="fas fa-briefcase"></i> Work Address
                </div>
                <div class="address-details">
                    <p>John Doe</p>
                    <p>456 Business Ave, Floor 12</p>
                    <p>New York, NY 10005</p>
                    <p>United States</p>
                    <p><strong>Phone:</strong> (555) 987-6543</p>
                </div>
                <div class="address-actions">
                    <button class="action-btn"><i class="fas fa-edit"></i> Edit</button>
                    <button class="action-btn"><i class="fas fa-trash"></i> Delete</button>
                    <button class="action-btn"><i class="fas fa-star"></i> Set Default</button>
                </div>
            </div>
            
            <div class="add-address-card" id="addAddressBtn">
                <div class="add-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <p class="add-text">Add New Address</p>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Address Modal -->
    <div class="modal" id="addressModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Address</h2>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            
            <form id="addressForm">
                <div class="form-group">
                    <label for="addressType">Address Type</label>
                    <select id="addressType" required>
                        <option value="">Select Type</option>
                        <option value="home">Home</option>
                        <option value="work">Work</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="streetAddress">Street Address</label>
                    <input type="text" id="streetAddress" required>
                </div>
                
                <div class="form-group">
                    <label for="apartment">Apartment, Suite, etc. (Optional)</label>
                    <input type="text" id="apartment">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province</label>
                        <input type="text" id="state" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="zipCode">ZIP/Postal Code</label>
                        <input type="text" id="zipCode" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" required>
                            <option value="">Select Country</option>
                            <option value="us">United States</option>
                            <option value="uk">United Kingdom</option>
                            <option value="ca">Canada</option>
                            <option value="au">Australia</option>
                            <option value="in">India</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" required>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="setDefault">
                    <label for="setDefault">Set as default shipping address</label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const addAddressBtn = document.getElementById('addAddressBtn');
        const addressModal = document.getElementById('addressModal');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const addressForm = document.getElementById('addressForm');
        
        addAddressBtn.addEventListener('click', () => {
            addressModal.style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Add New Address';
            addressForm.reset();
        });
        
        closeModal.addEventListener('click', () => {
            addressModal.style.display = 'none';
        });
        
        cancelBtn.addEventListener('click', () => {
            addressModal.style.display = 'none';
        });
        
        addressForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you would normally save the address data
            alert('Address saved successfully!');
            addressModal.style.display = 'none';
        });
        
        // Close modal when clicking outside the content
        window.addEventListener('click', (e) => {
            if (e.target === addressModal) {
                addressModal.style.display = 'none';
            }
        });
        
        // Set default address functionality
        const setDefaultButtons = document.querySelectorAll('.action-btn .fa-star');
        setDefaultButtons.forEach(button => {
            button.closest('.action-btn').addEventListener('click', function() {
                const card = this.closest('.address-card');
                document.querySelectorAll('.address-card').forEach(c => c.classList.remove('default'));
                document.querySelectorAll('.default-badge').forEach(b => b.remove());
                
                card.classList.add('default');
                
                const badge = document.createElement('span');
                badge.className = 'default-badge';
                badge.textContent = 'Default';
                card.querySelector('.address-type').after(badge);
                
                // Remove the set default button from this card
                this.remove();
            });
        });
    </script>
</body>
</html>