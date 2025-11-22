<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            /* Modern Color Palette */
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 70px;

            --primary-color: #6366f1; /* Indigo */
            --primary-hover: #4f46e5;
            
            --sidebar-bg: #1e293b; /* Slate 800 */
            --sidebar-text: #94a3b8;
            --sidebar-text-hover: #ffffff;
            --sidebar-active-bg: rgba(255, 255, 255, 0.1);
            
            --body-bg: #f3f4f6;
            --topbar-bg: rgba(255, 255, 255, 0.9);
            --text-color: #334155;
            --border-color: #e2e8f0;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: var(--body-bg);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            overflow-x: hidden;
        }

        a { text-decoration: none; }

        /* ==================================
           LAYOUT WRAPPER
        ================================== */
        #layout-wrapper {
            min-height: 100vh;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .page-content {
            padding: 1.5rem;
        }

        /* ==================================
           SIDEBAR (App Menu)
        ================================== */
        .app-menu {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1005;
            transition: all 0.3s ease;
            box-shadow: 4px 0 24px 0 rgba(0,0,0,0.02);
        }

        .navbar-brand-box {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1rem;
            background-color: rgba(0,0,0,0.1); /* Slightly darker than sidebar */
        }

        .navbar-brand-box .logo-light { display: block; height: 40px; }
        .navbar-brand-box .logo-sm { display: none; height: 30px; }

        /* Sidebar Scrollbar Customization */
        .sidebar-content {
            height: calc(100vh - var(--topbar-height));
            overflow-y: auto;
            padding: 10px 0;
        }
        .sidebar-content::-webkit-scrollbar { width: 5px; }
        .sidebar-content::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        .sidebar-content::-webkit-scrollbar-track { background: transparent; }

        /* Navigation Links */
        .navbar-nav { padding: 0 10px; }
        .nav-item { margin-bottom: 2px; }

        .app-menu .nav-link {
            color: var(--sidebar-text) !important;
            padding: 10px 15px;
            border-radius: 8px; /* Rounded pills */
            font-weight: 400;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            font-size: 0.92rem;
        }

        .app-menu .nav-link i {
            font-size: 1.2rem;
            min-width: 30px;
            color: inherit;
            transition: 0.2s;
        }

        .app-menu .nav-link:hover {
            color: var(--sidebar-text-hover) !important;
            background-color: rgba(255,255,255,0.05);
        }

        .app-menu .nav-link.active, 
        .app-menu .nav-link[aria-expanded="true"] {
            color: #fff !important;
            background-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); /* Glow effect */
            font-weight: 500;
        }

        /* Submenu Styling */
        .collapse .nav-link {
            padding-left: 45px;
            font-size: 0.85rem;
            background: transparent !important;
            color: var(--sidebar-text) !important;
            box-shadow: none !important;
        }
        .collapse .nav-link:hover {
            color: #fff !important;
        }
        .collapse .nav-link.active {
            color: var(--primary-color) !important; /* Accent color for active sub-item */
            font-weight: 600;
        }
        .collapse .nav-link::before {
            content: "";
            width: 6px;
            height: 6px;
            background-color: currentColor;
            border-radius: 50%;
            position: absolute;
            left: 25px;
            opacity: 0.5;
        }

        /* Logout Button Special Style */
        .nav-link-logout {
            margin-top: 20px;
            background-color: rgba(239, 68, 68, 0.1); /* Soft red bg */
            color: #ef4444 !important;
        }
        .nav-link-logout:hover {
            background-color: #ef4444 !important; /* Red */
            color: #fff !important;
        }

        /* ==================================
           TOP BAR
        ================================== */
        #page-topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1002;
            background-color: var(--topbar-bg);
            backdrop-filter: blur(10px); /* Glassmorphism */
            -webkit-backdrop-filter: blur(10px);
            height: var(--topbar-height);
            border-bottom: 1px solid var(--border-color);
            transition: left 0.3s ease;
        }

        .navbar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding: 0 1.5rem;
        }

        #topnav-hamburger-icon {
            border: none;
            background: transparent;
            color: var(--text-color);
            font-size: 1.4rem;
            cursor: pointer;
        }

        /* User Profile Dropdown */
        .user-dropdown .dropdown-toggle::after { display: none; }
        
        .user-dropdown .user-avatar {
            background-color: #e0e7ff;
            color: var(--primary-color);
            transition: 0.3s;
        }
        
        .user-dropdown .btn:hover .user-avatar {
            background-color: var(--primary-color);
            color: #fff;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-md);
            border-radius: 8px;
            padding: 0.5rem 0;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            font-size: 0.9rem;
            color: var(--text-color);
        }
        .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--primary-color);
        }
        .dropdown-item i {
            vertical-align: middle;
            margin-right: 5px;
            color: #94a3b8;
        }

        /* ==================================
           RESPONSIVE & COLLAPSED STATES
        ================================== */
        
        /* Desktop Collapsed (Vertical Icon View) */
        body.vertical-collapsed .app-menu {
            width: var(--sidebar-collapsed-width);
        }
        body.vertical-collapsed .app-menu:hover {
            width: var(--sidebar-width); /* Expand on hover */
        }
        body.vertical-collapsed .main-content,
        body.vertical-collapsed #page-topbar {
            margin-left: var(--sidebar-collapsed-width);
            left: var(--sidebar-collapsed-width);
        }
        
        body.vertical-collapsed .navbar-brand-box .logo-light { display: none; }
        body.vertical-collapsed .navbar-brand-box .logo-sm { display: block; margin: 0 auto; }
        
        body.vertical-collapsed .app-menu .menu-title {
            display: none; /* Hide text */
        }
        /* Show text if hovering over collapsed sidebar */
        body.vertical-collapsed .app-menu:hover .menu-title {
            display: inline-block;
        }
        body.vertical-collapsed .app-menu:hover .logo-light { display: block; }
        body.vertical-collapsed .app-menu:hover .logo-sm { display: none; }


        /* Mobile View (< 992px) */
        @media (max-width: 991.98px) {
            .app-menu {
                transform: translateX(-100%);
            }
            .main-content, #page-topbar {
                margin-left: 0 !important;
                left: 0 !important;
            }
            body.sidebar-enable .app-menu {
                transform: translateX(0);
            }
            .vertical-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1004;
            }
            body.sidebar-enable .vertical-overlay {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex align-items-center">
                    <button type="button" id="topnav-hamburger-icon" class="px-3">
                        <i class="ri-menu-2-line"></i>
                    </button>
                </div>

                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle p-0" type="button" id="userMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <i class="ri-user-fill rounded-circle p-2 fs-4 user-avatar"></i>
                            <span class="ms-2 d-none d-md-inline-block fw-medium">
                                {{ Auth::guard('admin')->user()->name }}
                                <i class="ri-arrow-down-s-line ms-1 text-muted"></i>
                            </span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="ri-user-settings-line"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                                onclick="event.preventDefault(); document.getElementById('top-logout-form').submit();">
                                <i class="ri-logout-box-r-line"></i> Logout
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}" id="top-logout-form" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/assets/images/users/loan.jpg') }}" alt="Logo" class="logo-light rounded-circle">
                    <img src="{{ asset('assets/assets/images/users/loan.jpg') }}" alt="Logo" class="logo-sm rounded-circle">
                </a>
            </div>

            <div class="sidebar-content">
                <ul class="navbar-nav" id="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="ri-dashboard-2-line"></i> <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                   

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/sms/agents*') ? 'active' : '' }}"
                           href="{{ route('admin.sms.agents') }}">
                            <i class="ri-notification-3-line"></i>
                            <span class="menu-title">Notification</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#customersMenu" role="button" aria-expanded="false">
                            <i class="ri-user-line"></i> <span class="menu-title">Customers</span>
                        </a>
                        <div class="collapse" id="customersMenu" data-bs-parent="#navbar-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.customers.index') }}">All Customers</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.contacts.index') }}">Customer Enquiries</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#goldItemsMenu" role="button" aria-expanded="false">
                            <i class="ri-coins-line"></i> <span class="menu-title">Gold Items</span>
                        </a>
                        <div class="collapse" id="goldItemsMenu" data-bs-parent="#navbar-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.gold_items.create') }}">Create Gold Item</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.gold_items.index') }}">View Gold Items</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#banksMenu" role="button" aria-expanded="false">
                            <i class="ri-bank-line"></i> <span class="menu-title">Banks</span>
                        </a>
                        <div class="collapse" id="banksMenu" data-bs-parent="#navbar-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.bank.index') }}">List Banks</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.bank.create') }}">Create Bank</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#branchMenu" role="button" aria-expanded="false">
                            <i class="ri-building-2-line"></i> <span class="menu-title">Branches</span>
                        </a>
                        <div class="collapse" id="branchMenu" data-bs-parent="#navbar-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.branch.index') }}">List Branches</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.branch.create') }}">Create Branch</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#agentsMenu" role="button" aria-expanded="false">
                            <i class="ri-user-3-line"></i> <span class="menu-title">Master</span>
                        </a>
                        <div class="collapse" id="agentsMenu" data-bs-parent="#navbar-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.agent.index') }}">List Master</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.agent.create') }}">Create Master</a></li>
                            </ul>
                        </div>
                    </li>

                 <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#appraisalMenu" role="button" aria-expanded="false">
        <i class="ri-file-list-3-line"></i> <span class="menu-title">Appraisal</span>
    </a>
    <div class="collapse" id="appraisalMenu" data-bs-parent="#navbar-nav">
        <ul class="nav flex-column">

            {{-- First Appraisal --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.appraisal.*') ? 'active' : '' }}"
                    href="{{ route('admin.appraisal.index') }}">
                    First Appraisal
                </a>
            </li>

            {{-- Second Appraisal --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/second-appraisal*') ? 'active' : '' }}"
                    href="{{ route('admin.second-appraisal.index') }}">
                    Second Appraisal
                </a>
            </li>

            {{-- 🔥 New Menu — Second Gold Items --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/second-gold-items*') ? 'active' : '' }}"
                    href="{{ route('admin.second_gold_items.index') }}">
                    Second Gold Items
                </a>
            </li>

        </ul>
    </div>
</li>


                    @php
                        $admin = auth('admin')->user();
                    @endphp

                    @if($admin->isSuperAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.manage_admins.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#adminMgmtMenu" role="button">
                                <i class="ri-admin-line"></i> <span class="menu-title">Admin Management</span>
                            </a>
                             <div class="collapse" id="adminMgmtMenu" data-bs-parent="#navbar-nav">
                                <ul class="nav flex-column">
                                     <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.manage_admins.create') }}">Create Admin</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.manage_admins.index') }}">All Admin List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
                            <i class="ri-receipt-line"></i>
                            <span class="menu-title">Invoices</span>
                        </a>
                    </li>
           {{-- Slot Booking --}}
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#slotBookingMenu" role="button" aria-expanded="false">
        <i class="ri-calendar-check-line"></i>
        <span class="menu-title">Slot Booking</span>
    </a>

    <div class="collapse" id="slotBookingMenu" data-bs-parent="#navbar-nav">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.slot-bookings.index') }}">
                    All Bookings
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.slot-bookings.create') }}">
                    Create Booking
                </a>
            </li>

        </ul>
    </div>
</li>


                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.logout') }}" id="sidebar-logout-form">
                            @csrf
                            <a href="#" class="nav-link nav-link-logout" 
                                onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                <i class="ri-logout-box-r-line"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="ri-error-warning-line me-2 align-middle fs-5"></i> 
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- 1. Helper: Manage Sidebar View on Resize ---
            function manageSidebarView() {
                if (window.innerWidth < 992) {
                    document.body.classList.remove('vertical-collapsed');
                } else {
                    document.body.classList.remove('sidebar-enable');
                }
            }

            // --- 2. Toggle Button Logic ---
            const hamburgerIcon = document.getElementById('topnav-hamburger-icon');
            if (hamburgerIcon) {
                hamburgerIcon.addEventListener('click', function () {
                    if (window.innerWidth < 992) {
                        document.body.classList.toggle('sidebar-enable');
                    } else {
                        document.body.classList.toggle('vertical-collapsed');
                    }
                });
            }

            // --- 3. Overlay Click (Mobile) ---
            const verticalOverlay = document.querySelector('.vertical-overlay');
            if (verticalOverlay) {
                verticalOverlay.addEventListener('click', function () {
                    document.body.classList.remove('sidebar-enable');
                });
            }

            // --- 4. Active Menu Management ---
            // Matches current URL to sidebar links and expands parent menus
            const currentUrl = window.location.href.split(/[?#]/)[0];
            const navLinks = document.querySelectorAll(".app-menu .nav-link");

            navLinks.forEach(function (link) {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                    
                    // If inside a collapse menu, expand it
                    const parentCollapse = link.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        
                        // Highlight the parent trigger
                        const parentTrigger = document.querySelector('a[href="#' + parentCollapse.id + '"]');
                        if (parentTrigger) {
                            parentTrigger.classList.add('active');
                            parentTrigger.setAttribute('aria-expanded', 'true');
                        }
                    }
                }
            });
            
            // --- 5. Auto-Close Mobile Sidebar on Link Click ---
            const allMenuLinks = document.querySelectorAll('.app-menu a');
            allMenuLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // Don't close if it's a dropdown trigger
                    if (link.getAttribute('data-bs-toggle') === 'collapse') return;
                    
                    if (window.innerWidth < 992 && document.body.classList.contains('sidebar-enable')) {
                        document.body.classList.remove('sidebar-enable');
                    }
                });
            });

            // Init
            window.addEventListener('resize', manageSidebarView);
            manageSidebarView();
        });
    </script>

    @stack('scripts')
</body>
</html>