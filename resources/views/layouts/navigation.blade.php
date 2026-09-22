<nav x-data="{ open: false }" class="topbar">
    <div class="topbar-inner">
        <div class="topbar-left">
            <x-logo class="topbar-logo" />
            <span class="topbar-label">Maintenance App</span>
        </div>

        <div class="topbar-center">
            <form class="topbar-search" action="{{ route('workshops.index') }}" method="GET">
                <input type="search" name="search" placeholder="Search workshops, partners, locations..." class="topbar-search-input" value="{{ request('search') }}" />
            </form>
            <nav class="topbar-pills" aria-label="Quick navigation">
                <a class="topbar-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a>
                <a class="topbar-pill {{ request()->routeIs('workshops.index') ? 'active' : '' }}" href="{{ route('workshops.index') }}" @if(request()->routeIs('workshops.index')) aria-current="page" @endif>Reservations</a>
                <a class="topbar-pill" href="{{ route('workshops.export.pdf') }}">Reports</a>
            </nav>
        </div>

        <div class="topbar-right">
            <div class="topbar-stats">
                <div class="stat-item"><strong id="today-stat">{{ \App\Models\WorkshopSubscription::whereDate('starts_at', now())->count() }}</strong><small>Today</small></div>
                <div class="stat-item onrent">
                    <strong id="onrent-stat">
                        {{ \App\Models\WorkshopSubscription::where(function($q){ $q->where('status','on_rent')->orWhere(function($q2){ $q2->where('status','active')->whereDate('starts_at','<=', now())->whereDate('ends_at','>=', now()); }); })->count() }}
                    </strong>
                    <small>On Rent</small>
                </div>
            </div>
            <button id="theme-toggle" type="button" class="theme-toggle">Dark mode</button>
            <div class="topbar-user">{{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="raw-button secondary topbar-button">Logout</button>
            </form>
        </div>
    </div>
</nav>

@php
    $currentRouteName = request()->route() ? request()->route()->getName() : '';
@endphp

<script>
            document.addEventListener('DOMContentLoaded', function () {
                const routeName = '{{ $currentRouteName }}';
                const sidebarLinks = document.querySelectorAll('.sidebar-link');
                sidebarLinks.forEach((link) => {
                    const href = link.getAttribute('href');
                    if (!href) return;

                    const match = href.includes('dashboard') && routeName === 'dashboard'
                        || href.includes('workshops') && routeName === 'workshops.index'
                        || href.includes('profile') && routeName === 'profile.edit';

                    if (match) {
                        link.classList.add('active');
                    }
                });

                // Poll topbar stats every 5 seconds
                const updateStats = async () => {
                    try {
                        const res = await fetch('/topbar/stats');
                        if (!res.ok) return;
                        const json = await res.json();
                        const todayEl = document.getElementById('today-stat');
                        const onrentEl = document.getElementById('onrent-stat');
                        if (todayEl) todayEl.textContent = json.today;
                        if (onrentEl) onrentEl.textContent = json.on_rent;
                    } catch (e) {
                        console.error('Failed to update topbar stats', e);
                    }
                };

                // initial poll and interval
                updateStats();
                setInterval(updateStats, 5000);
            });
</script>
