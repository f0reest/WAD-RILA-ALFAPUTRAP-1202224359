<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Maintenance Workshop Module') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell antialiased">
        <div class="auth-panel-wrap">
            <div class="auth-brand-block">
                <div class="auth-brand-topline">
                    <span class="auth-badge">Maintenance</span>
                    <span class="auth-badge secondary">Ops</span>
                </div>
                <h1 class="auth-brand-title">Maintenance<br>Workshop</h1>
                <p class="auth-brand-copy">Individual D module for workshop subscriptions, maintenance partners, locations, contacts, and service types.</p>
                <div class="auth-brand-footer">
                    <span class="auth-mini-label">Live</span>
                    <span class="auth-mini-value">Service readiness</span>
                </div>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
