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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #2c3e50;
            --sidebar-link-color: #ecf0f1;
            --sidebar-link-hover-bg: #34495e;
            --sidebar-link-active-color: #ffffff;
            --primary-accent: #3498db;
            --content-bg: #f4f6f9;
            --topbar-bg: #ffffff;
            --border-color: #e0e0e0;
            --text-color: #333;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--content-bg);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
        }

        /*
        ==================================
        |        MAIN LAYOUT             |
        ==================================
        */
        #layout-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 260px;
            padding-top: 70px;
            transition: margin-left 0.3s ease;
        }

        .page-content {
            padding: 1.5rem;
        }

        /*
        ==================================
        |        TOP BAR                 |
        ==================================
        */
        #page-topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            z-index: 1002;
            background-color: var(--topbar-bg);
            height: 70px;
            transition: left 0.3s ease;
            border-bottom: 1px solid var(--border-color);
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
            color: #555;
            font-size: 1.25rem;
        }

        .user-dropdown .dropdown-toggle {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            color: var(--text-color);
        }
        .user-dropdown .dropdown-toggle::after {
            display: none; /* Hide default bootstrap caret */
        }
        .user-dropdown .user-avatar {
            height: 36px;
            width: 36px;
            background-color: var(--content-bg);
            color: var(--primary-accent);
        }

        /*
        ==================================
        |        SIDEBAR                 |
        ==================================
        */
        .app-menu {
            width: 260px;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1005;
            transition: transform 0.3s ease, width 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Hide scrollbar */
        .app-menu {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .app-menu::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .navbar-brand-box {
            padding: 1rem;
            text-align: center;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--sidebar-link-hover-bg);
        }

        .navbar-brand-box .logo-light {
            display: inline-block;
            height: 40px;
        }

        .navbar-brand-box .logo-sm {
            display: none;
            height: 30px;
        }

        .navbar-nav {
            padding: 1rem;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .app-menu .nav-link {
            color: var(--sidebar-link-color) !important;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease, color 0.2s ease;
            border-left: 3px solid transparent;
        }

        .app-menu .nav-link i {
            font-size: 1.2rem;
            min-width: 30px;
            margin-right: 10px;
            line-height: 1;
        }

        .app-menu .nav-link .menu-title {
            opacity: 1;
            transition: opacity 0.2s ease-in-out;
        }

        .app-menu .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-link-active-color) !important;
        }

        .app-menu .nav-link.active,
        .app-menu .nav-link[aria-expanded="true"] {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-link-active-color) !important;
            font-weight: 500;
        }
        
        /* Highlight active link with border */
        .app-menu .nav-link.active {
             border-left-color: var(--primary-accent);
        }

        /* Sub-menu styling */
        .collapse .nav-link {
            padding-left: 30px;
            font-size: 0.9rem;
            color: var(--sidebar-link-color) !important;
            border-left: none !important; /* No border for sub-items */
        }

        .collapse .nav-link::before {
            content: "•";
            min-width: 30px;
            margin-right: 10px;
            color: var(--sidebar-link-color);
        }

        .collapse .nav-link:hover {
            background: transparent;
            color: var(--sidebar-link-active-color) !important;
        }

        .collapse .nav-link.active {
            color: var(--sidebar-link-active-color) !important;
            font-weight: 500;
            background: transparent;
        }

        /* Logout button styling */
        .nav-link-logout {
            margin-top: 2rem;
        }
        .nav-link-logout:hover {
            background-color: #e74c3c !important;
            color: #fff !important;
        }
        .nav-link-logout:hover i {
            color: #fff !important;
        }
        
        /*
        ==================================
        |        COLLAPSED SIDEBAR       |
        ==================================
        */
        body.vertical-collapsed .app-menu {
            width: 80px;
        }

        body.vertical-collapsed .main-content,
        body.vertical-collapsed #page-topbar {
            margin-left: 80px;
            left: 80px;
        }

        body.vertical-collapsed .menu-title,
        body.vertical-collapsed .navbar-brand-box .logo-light {
            opacity: 0;
            width: 0;
            display: none;
        }
        
        body.vertical-collapsed .app-menu .nav-link {
            justify-content: center;
        }
        
        body.vertical-collapsed .app-menu .nav-link i {
            margin-right: 0;
        }

        body.vertical-collapsed .navbar-brand-box .logo-sm {
            display: inline-block;
        }
        
        body.vertical-collapsed .nav-item .collapse {
            display: none !important;
        }

        body.vertical-collapsed .nav-link[data-bs-toggle="collapse"]::after {
            display: none; /* Hide collapse arrow */
        }

        /*
        ==================================
        |        MOBILE RESPONSIVE       |
        ==================================
        */
        .vertical-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1004;
        }

        @media (max-width: 991.98px) {
            .app-menu {
                transform: translateX(-100%);
            }

            body.sidebar-enable .app-menu {
                transform: translateX(0);
            }

            .main-content,
            #page-topbar {
                margin-left: 0 !important;
                left: 0 !important;
            }

            .vertical-overlay {
                display: block;
            }

            body.sidebar-enable .vertical-overlay {
                opacity: 1;
                visibility: visible;
            }

            body:not(.sidebar-enable) .vertical-overlay {
                opacity: 0;
                visibility: hidden;
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
                    <button type="button" id="topnav-hamburger-icon" class="btn btn-sm px-3 fs-16">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>

                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ri-user-fill rounded-circle p-2 fs-4 user-avatar"></i>
                        <span class="ms-2 d-none d-md-inline-block">
                            {{ Auth::guard('admin')->user()->name }}
                            <i class="ri-arrow-down-s-line ms-1"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      
                      <li>
<li>
    <a class="dropdown-item" href="{{ route('admin.profile') }}">
        <i class="ri-user-settings-line align-middle me-1"></i> Profile
    </a>
</li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                                onclick="event.preventDefault(); document.getElementById('top-logout-form').submit();">
                                <i class="ri-logout-box-r-line align-middle me-1"></i> Logout
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
                    <img src="{{ asset('assets/assets/images/users/loan.jpg') }}" alt="Logo" class="logo-light">
                    <img src="{{ asset('assets/assets/images/users/loan.jpg') }}" alt="Logo" class="logo-sm">
                </a>
            </div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span class="menu-title">Dashboard</span>
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
                    <a class="nav-link {{ request()->routeIs('admin.appraisal.*') ? 'active' : '' }}" href="{{ route('admin.appraisal.index') }}">
                        <i class="ri-file-list-3-line"></i>
                        <span class="menu-title">Appraisal</span>
                    </a>
                </li>

              @php
    $admin = auth('admin')->user();
@endphp

@if($admin->isSuperAdmin())
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.manage_admins.*') ? 'active' : '' }}" 
           href="{{ route('admin.manage_admins.create') }}">
            <i class="ri-admin-line"></i>
            <span class="menu-title">Manage Admin</span>
        </a>
    </li>

    <!-- NEW: All Admin List -->
 <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.manage_admins.*') ? 'active' : '' }}" 
       href="{{ route('admin.manage_admins.index') }}">
        <i class="ri-user-settings-line"></i>
        <span class="menu-title">All Admin List</span>
    </a>
</li>

@endif


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
                        <i class="ri-receipt-line"></i>
                        <span class="menu-title">Invoices</span>
                    </a>
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

        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
            
            // --- Helper Function to manage sidebar state on resize ---
            function manageSidebarView() {
                const windowWidth = window.innerWidth;
                if (windowWidth < 992) {
                    document.body.classList.remove('vertical-collapsed'); // Exit desktop collapsed mode
                } else {
                    document.body.classList.remove('sidebar-enable'); // Exit mobile slide-in mode
                }
            }

            // --- Sidebar Toggle Handler ---
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

            // --- Close mobile sidebar on overlay click ---
            const verticalOverlay = document.querySelector('.vertical-overlay');
            if (verticalOverlay) {
                verticalOverlay.addEventListener('click', function () {
                    document.body.classList.remove('sidebar-enable');
                });
            }

            // --- Set Active Menu Item ---
            // This part ensures the current page's link is active *in the submenu*.
            // Parent menu items are handled by Blade's request()->routeIs()
            const currentUrl = window.location.href.split(/[?#]/)[0];
            const navLinks = document.querySelectorAll(".app-menu .nav-link");

            navLinks.forEach(function (link) {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                    
                    const parentCollapse = link.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        
                        // Activate the parent menu link
                        const parentLink = document.querySelector('a[href="#' + parentCollapse.id + '"]');
                        if (parentLink) {
                            parentLink.classList.add('active');
                            parentLink.setAttribute('aria-expanded', 'true');
                        }
                    }
                }
            });

            // --- Auto close mobile sidebar after a menu link click ---
            const allMenuLinks = document.querySelectorAll('.app-menu a');
            allMenuLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // If it's a collapsible link or logout, don't close
                    if (link.getAttribute('data-bs-toggle') === 'collapse' || link.closest('#sidebar-logout-form')) {
                        return;
                    }
                    
                    if (window.innerWidth < 992 && document.body.classList.contains('sidebar-enable')) {
                        document.body.classList.remove('sidebar-enable');
                    }
                });
            });

            // --- Window Resize Listener ---
            window.addEventListener('resize', manageSidebarView);

            // --- Initialize View on Load ---
            manageSidebarView();
        });
    </script>

    @stack('scripts')
</body>

</html>