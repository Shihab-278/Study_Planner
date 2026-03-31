<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <meta name="color-scheme" content="light dark" />
        <meta name="supported-color-schemes" content="light dark" />
        <title>AdminLTE 4 | @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
            crossorigin="anonymous"
            media="print"
            onload="this.media = 'all'"
        />

        <!-- Third-party CSS -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
            crossorigin="anonymous"
        />

        <!-- AdminLTE main CSS (local) -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">

        @stack('head')
    </head>

    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        <div class="app-wrapper">

            <!-- Navbar -->
            <nav class="app-header navbar navbar-expand bg-body">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">☰</a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a href="#" class="nav-link">Home</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                                <i class="bi bi-search"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Sidebar -->
            <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
                <div class="sidebar-brand">
                    <a href="#" class="brand-link px-3">
                        <span class="brand-text fw-light">AdminLTE</span>
                    </a>
                </div>

                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon bi bi-speedometer"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-table"></i>
                                    <p>Tables</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Main content area (keep user's content here) -->
            <main class="app-main">
                <div class="app-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="app-footer">
                <div class="float-end d-none d-sm-inline">Anything you want</div>
                <strong>Copyright &copy; 2014-2025 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

        <!-- Optional additional scripts from index.html -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebarWrapper = document.querySelector('.sidebar-wrapper');
                const isMobile = window.innerWidth <= 992;
                if (sidebarWrapper && window.OverlayScrollbars && !isMobile) {
                    OverlayScrollbars(sidebarWrapper, { scrollbars: { theme: 'os-theme-light', autoHide: 'leave', clickScroll: true } });
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
