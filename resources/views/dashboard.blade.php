<x-app-layout>
    <x-slot name="header">
        <div class="hero-header operations-header">
            <div>
                <span class="raw-kicker">Maintenance operations</span>
                <h1 class="raw-title">Workshop subscriptions</h1>
                <p class="page-intro">Manage subscriptions and the partner network that supports every maintenance service.</p>
            </div>
            <a href="{{ route('workshops.index') }}" class="raw-button">Manage workshop data</a>
        </div>
    </x-slot>

    @php
        $activeSubscriptions = \App\Models\WorkshopSubscription::where('status', 'active')->count();
        $pendingSubscriptions = \App\Models\WorkshopSubscription::where('status', 'pending')->count();
        $totalSubscriptions = \App\Models\WorkshopSubscription::count();
    @endphp

    <section class="ops-overview" aria-labelledby="overview-title">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">Live overview</span>
                <h2 id="overview-title">Operational summary</h2>
            </div>
            <span class="updated-label">Current database totals</span>
        </div>

        <div class="ops-metric-grid">
            <article class="ops-metric metric-primary">
                <span class="metric-label">Subscriptions</span>
                <strong>{{ $totalSubscriptions }}</strong>
                <span class="metric-note">{{ $activeSubscriptions }} currently active</span>
            </article>
            <article class="ops-metric">
                <span class="metric-label">Maintenance partners</span>
                <strong>{{ \App\Models\WorkshopPartner::count() }}</strong>
                <span class="metric-note">Registered service providers</span>
            </article>
            <article class="ops-metric">
                <span class="metric-label">Locations</span>
                <strong>{{ \App\Models\WorkshopLocation::count() }}</strong>
                <span class="metric-note">Service coverage points</span>
            </article>
            <article class="ops-metric">
                <span class="metric-label">Contacts</span>
                <strong>{{ \App\Models\WorkshopContact::count() }}</strong>
                <span class="metric-note">Partner representatives</span>
            </article>
        </div>
    </section>

    <section class="ops-panel" aria-labelledby="workspace-title">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">Workspace</span>
                <h2 id="workspace-title">Data management</h2>
            </div>
        </div>

        <div class="management-grid">
            <a class="management-item featured" href="{{ route('workshops.index') }}#subscriptions">
                <span class="management-index">01</span>
                <div><h3>Subscriptions</h3><p>Create, review, update, and export workshop subscription records.</p></div>
                <span class="management-count">{{ $totalSubscriptions }}</span>
            </a>
            <a class="management-item" href="{{ route('workshops.index') }}#master-data">
                <span class="management-index">02</span>
                <div><h3>Partners</h3><p>Maintain partner identity, contact details, and operating status.</p></div>
                <span class="management-count">{{ \App\Models\WorkshopPartner::count() }}</span>
            </a>
            <a class="management-item" href="{{ route('workshops.index') }}#master-data">
                <span class="management-index">03</span>
                <div><h3>Locations</h3><p>Organize service locations, addresses, and geographic coordinates.</p></div>
                <span class="management-count">{{ \App\Models\WorkshopLocation::count() }}</span>
            </a>
            <a class="management-item" href="{{ route('workshops.index') }}#master-data">
                <span class="management-index">04</span>
                <div><h3>Contacts &amp; services</h3><p>Connect responsible contacts with the available maintenance services.</p></div>
                <span class="management-count">{{ \App\Models\WorkshopServiceType::count() }}</span>
            </a>
        </div>
    </section>

    <section class="status-strip" aria-label="Subscription status summary">
        <div><span>Active</span><strong>{{ $activeSubscriptions }}</strong></div>
        <div><span>Pending review</span><strong>{{ $pendingSubscriptions }}</strong></div>
        <div class="status-strip-action">
            <span>Need detailed records?</span>
            <a href="{{ route('workshops.index') }}">Open the workshop register <span aria-hidden="true">→</span></a>
        </div>
    </section>
</x-app-layout>
