<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Maintenance Workshop Module') }}</title>

        <script>
            (function () {
                const savedTheme = localStorage.getItem('maintenance-theme');
                const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                document.documentElement.dataset.theme = savedTheme || preferredTheme;
            })();
        </script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/css/neo.css', 'resources/js/app.js'])
    </head>
    <body class="raw-shell antialiased">
        <div class="app-shell">
            @include('layouts.navigation')

            <div class="app-body">
                <aside class="app-sidebar">
                    <div class="sidebar-brand-block">
                        <x-logo class="sidebar-logo" />
                        <div>
                            <div class="sidebar-brand-name">Maintenance</div>
                            <div class="sidebar-brand-sub">Operations</div>
                        </div>
                    </div>

                    <nav class="sidebar-nav" aria-label="Sidebar navigation">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('workshops.index') }}" class="sidebar-link {{ request()->routeIs('workshops.index') ? 'active' : '' }}">
                            <span>Workshop Module</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <span>Profile</span>
                        </a>
                    </nav>

                    <div class="sidebar-summary">
                        <span class="sidebar-label">Live</span>
                        <strong>Service readiness</strong>
                    </div>
                </aside>

                <div class="app-content">
                    @if (isset($header))
                        <header class="raw-header">
                            {{ $header }}
                        </header>
                    @endif

                    <main class="app-main">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const body = document.body;
                const themeToggle = document.getElementById('theme-toggle');
                const savedTheme = document.documentElement.dataset.theme || 'light';

                const applyTheme = (theme) => {
                    document.documentElement.setAttribute('data-theme', theme);
                    body.setAttribute('data-theme', theme);
                    if (themeToggle) {
                        themeToggle.textContent = theme === 'dark' ? 'Light mode' : 'Dark mode';
                        themeToggle.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
                    }
                };

                applyTheme(savedTheme);

                if (themeToggle) {
                    themeToggle.addEventListener('click', function () {
                        const nextTheme = body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                        localStorage.setItem('maintenance-theme', nextTheme);
                        applyTheme(nextTheme);
                    });
                }
            })();
        </script>
    </body>
</html>
