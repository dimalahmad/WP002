<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Work Permit | @yield('title', 'Dashboard')</title>

    <!-- Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />

    <!-- Plugin Pihak Ketiga (OverlayScrollbars) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <!-- Plugin Pihak Ketiga (Bootstrap Icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

    <!-- CSS AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.css') }}" />

    <style>
        /* Warna Kustom Aplikasi */
        :root {
            --bs-primary: #007bff;
            /* Sesuaikan dengan Warna Utama jika diperlukan */
        }

        .sidebar-brand {
            background-color: #343a40 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #4b545c;
        }

        .app-sidebar {
            /* Mengembalikan sidebar AdminLTE Dark default */
        }

        .app-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .app-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        .app-sidebar .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff !important;
        }

        .sidebar-brand .brand-image {
            /* Sesuaikan ukuran/gaya logo */
        }
    </style>
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('partials.navbar')

        @include('partials.sidebar')

        <!-- Konten Utama -->
        <!-- Konten Utama -->
        <main class="app-main">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <!-- Skrip -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/adminlte/js/adminlte.js') }}"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>