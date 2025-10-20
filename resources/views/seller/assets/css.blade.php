    <style>
        :root {
            --primary: #4361ee;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-bg: #1e2a4a;
            --sidebar-hover: #2d3e63;
            --sidebar-active: #4361ee;
            --header-bg: #ffffff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #495057;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(to bottom, var(--sidebar-bg), #1a243f);
            padding-top: 1.5rem;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header img {
            max-height: 40px;
            transition: var(--transition);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.85rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--sidebar-active);
            opacity: 0;
            transition: var(--transition);
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: var(--sidebar-hover);
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover:before,
        .sidebar .nav-link.active:before {
            opacity: 1;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* Navbar */
        .navbar {
            margin-left: 280px;
            background-color: var(--header-bg);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1.5rem;
            transition: var(--transition);
            z-index: 999;
        }

        .modal {
            z-index: 1055 !important;
            /* Higher than backdrop's default 1040 */
        }

        .modal-backdrop {
            z-index: 1040 !important;
            /* Ensure backdrop is below modal */
        }

        .navbar-brand img {
            height: 30px;
        }

        .content-wrapper {
            padding-top: 1.5rem;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.85rem;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: var(--transition);
        }

        .btn-action {
            padding: 0.35rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.35rem;
        }

        /* Tables */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            border-top: none;
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 1rem;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-inactive {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        /* User Dropdown */
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .user-dropdown .dropdown-toggle:hover {
            background-color: #f8f9fa;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown .dropdown-menu {
            min-width: 200px;
            padding: 0.5rem;
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.75rem;
            margin-top: 0.5rem;
        }

        .user-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .user-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }

            .main-content,
            .navbar {
                margin-left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 50px rgba(0, 0, 0, 0.2);
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
            }

            .overlay.show {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5a5a5;
        }

        /* Utilities */
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), #6a11cb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shadow-soft {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Analytics Dashboard Styles */
        .stat-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-body {
            display: flex;
            align-items: center;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex-grow: 1;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .change-up {
            color: #2ecc71;
        }

        .change-down {
            color: #e74c3c;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        .mini-chart-container {
            position: relative;
            height: 60px;
            width: 100%;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .recent-activity-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f2f6;
        }

        .recent-activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .top-product-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
        }

        .product-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .product-stats {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .product-sales {
            font-weight: 600;
            color: #2c3e50;
        }

        .progress-bar-container {
            background-color: #f1f2f6;
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
        }

        .filter-options {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: white;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome-message h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .welcome-message p {
            color: #7f8c8d;
            margin-bottom: 0;
        }

        .date-display {
            background: white;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            font-weight: 500;
            color: #2c3e50;
        }

        .date-display i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }
    </style>
        <!-- Custom CSS -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --sidebar-bg: #1e2a4a;
            --sidebar-hover: #2d3e63;
            --sidebar-active: #4361ee;
            --header-bg: #ffffff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #495057;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(to bottom, var(--sidebar-bg), #1a243f);
            padding-top: 1.5rem;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header img {
            max-height: 40px;
            transition: var(--transition);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.85rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--sidebar-active);
            opacity: 0;
            transition: var(--transition);
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: var(--sidebar-hover);
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover:before,
        .sidebar .nav-link.active:before {
            opacity: 1;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* Navbar */
        .navbar {
            margin-left: 280px;
            background-color: var(--header-bg);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1.5rem;
            transition: var(--transition);
            z-index: 999;
        }

        .modal {
            z-index: 1055 !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .navbar-brand img {
            height: 30px;
        }

        .content-wrapper {
            padding-top: 1.5rem;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.85rem;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: var(--transition);
        }

        .btn-action {
            padding: 0.35rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.35rem;
        }

        /* Tables */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            border-top: none;
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 1rem;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-inactive {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        /* User Dropdown */
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .user-dropdown .dropdown-toggle:hover {
            background-color: #f8f9fa;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown .dropdown-menu {
            min-width: 200px;
            padding: 0.5rem;
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.75rem;
            margin-top: 0.5rem;
        }

        .user-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .user-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Chat Styles */
        .chat-container {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            height: calc(100vh - 180px);
            overflow: hidden;
            margin-top: 20px;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid var(--light-gray);
        }

        .chat-user {
            display: flex;
            align-items: center;
        }

        .chat-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #7209b7, #4361ee);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 15px;
        }

        .chat-user-info h3 {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .chat-user-info p {
            font-size: 14px;
            color: var(--gray);
        }

        .chat-actions {
            display: flex;
            gap: 15px;
        }

        .action-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: #f9fafc;
        }

        .message {
            display: flex;
            max-width: 70%;
        }

        .message.received {
            align-self: flex-start;
        }

        .message.sent {
            align-self: flex-end;
        }

        .message-content {
            padding: 15px;
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        .message.received .message-content {
            background: white;
            border-top-left-radius: 4px;
        }

        .message.sent .message-content {
            background: var(--primary);
            color: white;
            border-top-right-radius: 4px;
        }

        .message-time {
            font-size: 12px;
            margin-top: 8px;
            opacity: 0.8;
        }

        .chat-input {
            display: flex;
            align-items: center;
            padding: 20px;
            border-top: 1px solid var(--light-gray);
            gap: 15px;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 15px 20px;
            border: 1px solid var(--light-gray);
            border-radius: 30px;
            font-size: 15px;
            transition: var(--transition);
        }

        .chat-input input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .chat-input-actions {
            display: flex;
            gap: 12px;
        }

        .chat-input-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .chat-input-btn:hover {
            background: var(--primary);
            color: white;
        }

        .send-btn {
            background: var(--primary);
            color: white;
        }

        .send-btn:hover {
            background: var(--primary-dark);
        }

        /* Meeting Scheduler */
        .meeting-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-top: 25px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .meeting-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .meeting-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .meeting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .meeting-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .meeting-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .meeting-time {
            font-size: 14px;
            color: var(--gray);
        }

        .meeting-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-upcoming {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .meeting-members {
            display: flex;
            margin-top: 15px;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -10px;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--dark);
        }

        .member-avatar:first-child {
            margin-left: 0;
        }

        .meeting-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--light-gray);
            color: var(--dark);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Scheduler Form */
        .scheduler-form {
            margin-top: 20px;
            display: none;
        }

        .scheduler-form.show {
            display: block;
        }

        .scheduler-form .form-group {
            margin-bottom: 15px;
        }

        .scheduler-form .form-control {
            border-radius: 30px;
        }

        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                height: auto;
                margin-bottom: 20px;
            }

            .chat-container {
                height: 500px;
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }

            .main-content,
            .navbar {
                margin-left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 50px rgba(0, 0, 0, 0.2);
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
            }

            .overlay.show {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5a5a5;
        }

        /* Utilities */
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), #6a11cb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shadow-soft {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Analytics Dashboard Styles */
        .stat-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-body {
            display: flex;
            align-items: center;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex-grow: 1;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .change-up {
            color: #2ecc71;
        }

        .change-down {
            color: #e74c3c;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        .mini-chart-container {
            position: relative;
            height: 60px;
            width: 100%;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .recent-activity-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f2f6;
        }

        .recent-activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .top-product-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
        }

        .product-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .product-stats {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .product-sales {
            font-weight: 600;
            color: #2c3e50;
        }

        .progress-bar-container {
            background-color: #f1f2f6;
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
        }

        .filter-options {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: white;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome-message h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .welcome-message p {
            color: #7f8c8d;
            margin-bottom: 0;
        }

        .date-display {
            background: white;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            font-weight: 500;
            color: #2c3e50;
        }

        .date-display i {
            margin-right: 0.5rem;
            color: var(--primary);
        }
    </style>
