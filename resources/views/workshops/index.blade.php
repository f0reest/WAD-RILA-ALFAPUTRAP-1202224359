<x-app-layout>
    <x-slot name="header">
        <div class="hero-header workshop-header">
            <div>
                <span class="raw-kicker">Workshop Management</span>
                <h1 class="raw-title">Workshop control</h1>
            </div>
            <div class="summary-badge">
                <div class="summary-label">Coverage</div>
                <div class="summary-value">{{ $partners->count() }} partners</div>
            </div>
        </div>
    </x-slot>

    <section class="raw-section">
        @php
            $selectedPlan = request('plan');
            $planDefaults = [
                'starter' => ['monthly_fee' => 0, 'status' => 'active', 'note' => 'Starter plan selected'],
                'pro' => ['monthly_fee' => 29, 'status' => 'active', 'note' => 'Pro plan selected'],
                'enterprise' => ['monthly_fee' => 0, 'status' => 'pending', 'note' => 'Contact sales for Enterprise']
            ];
            $planDefault = $planDefaults[$selectedPlan] ?? null;
        @endphp

        @if($selectedPlan)
            <div class="raw-card mb-6 px-4 py-3 text-sm font-semibold uppercase tracking-[0.12em]">
                Selected plan: <strong class="ml-2">{{ ucfirst($selectedPlan) }}</strong>
                @if($planDefault)
                    <span class="ml-4 text-muted"> - {{ $planDefault['note'] }}</span>
                @endif
            </div>
        @endif

        @if($selectedPlan)
            <!-- Plan selected banner remains; auto-scroll/highlight removed per revert -->
        @endif
        @if (session('success'))
            <div class="raw-card mb-6 px-4 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-neutral-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->subscription->any())
            <div class="manual-subscription-errors mb-6" role="alert" aria-labelledby="subscription-error-title">
                <strong id="subscription-error-title">Subscription belum tersimpan</strong>
                <ul>
                    @foreach ($errors->subscription->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('workshops.index') }}" class="table-toolbar mb-6">
            <div class="table-toolbar-left">
                <input name="search" type="text" class="raw-input" value="{{ request('search') }}" placeholder="Search by code, partner, service, status...">
            </div>
            <div class="table-toolbar-right">
                <a href="{{ route('workshops.index', ['create' => 'subscription']) }}#subscriptions" class="raw-button">Add subscription manually</a>
                <select name="status" class="raw-select">
                    <option value="">All statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
                <button type="submit" class="raw-button secondary">Search</button>
                <a href="{{ route('workshops.export.excel', request()->query()) }}" class="raw-button secondary">Export Excel</a>
                <a href="{{ route('workshops.export.pdf', request()->query()) }}" class="raw-button">Export PDF</a>
            </div>
        </form>

        <div id="master-data" class="raw-section-grid mb-6 scroll-target">
            <x-card title="Add partner">
                <form method="POST" action="{{ route('workshops.partners.store') }}" class="space-y-4">
                    @csrf
                    <div class="raw-form-grid">
                        <div>
                            <label class="raw-label">Partner name</label>
                            <input name="name" type="text" required class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Code</label>
                            <input name="code" type="text" required class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Email</label>
                            <input name="email" type="email" class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Phone</label>
                            <input name="phone" type="text" class="raw-input">
                        </div>
                    </div>
                    <div>
                        <label class="raw-label">Address</label>
                        <textarea name="address" rows="3" class="raw-textarea"></textarea>
                    </div>
                    <div class="raw-form-grid">
                        <div>
                            <label class="raw-label">City</label>
                            <input name="city" type="text" class="raw-input">
                        </div>
                        <div class="flex items-center gap-3 pt-8">
                            <input id="partner_is_active" name="is_active" type="checkbox" value="1" checked class="h-5 w-5 border-black bg-white text-red-600">
                            <label for="partner_is_active" class="raw-label !m-0">Active</label>
                        </div>
                    </div>
                    <button type="submit" class="raw-button">Save partner</button>
                </form>
            </x-card>

            <x-card title="Add location">
                <form method="POST" action="{{ route('workshops.locations.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="raw-label">Partner</label>
                        <select name="partner_id" required class="raw-select">
                            <option value="">Select partner</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="raw-form-grid">
                        <div>
                            <label class="raw-label">Location name</label>
                            <input name="name" type="text" required class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">City</label>
                            <input name="city" type="text" class="raw-input">
                        </div>
                    </div>
                    <div>
                        <label class="raw-label">Address</label>
                        <textarea name="address" rows="3" class="raw-textarea"></textarea>
                    </div>
                    <div class="raw-form-grid">
                        <div>
                            <label class="raw-label">Latitude</label>
                            <input name="latitude" type="number" step="0.0000001" class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Longitude</label>
                            <input name="longitude" type="number" step="0.0000001" class="raw-input">
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="raw-label !m-0">Status</label>
                        <select name="is_active" class="raw-select w-auto min-w-[140px]">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="raw-button">Save location</button>
                </form>
            </x-card>
        </div>

        <div class="raw-section-grid mb-6">
            <x-card title="Add contact">
                <form method="POST" action="{{ route('workshops.contacts.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="raw-label">Partner</label>
                        <select name="partner_id" required class="raw-select">
                            <option value="">Select partner</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="raw-form-grid">
                        <div>
                            <label class="raw-label">Name</label>
                            <input name="name" type="text" required class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Position</label>
                            <input name="position" type="text" class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Phone</label>
                            <input name="phone" type="text" class="raw-input">
                        </div>
                        <div>
                            <label class="raw-label">Email</label>
                            <input name="email" type="email" class="raw-input">
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="raw-label !m-0">Primary contact</label>
                        <select name="is_primary" class="raw-select w-auto min-w-[120px]">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <button type="submit" class="raw-button">Save contact</button>
                </form>
            </x-card>

            <x-card title="Add service type">
                <form method="POST" action="{{ route('workshops.service-types.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="raw-label">Type name</label>
                        <input name="name" type="text" required class="raw-input">
                    </div>
                    <div>
                        <label class="raw-label">Description</label>
                        <textarea name="description" rows="4" class="raw-textarea"></textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <input id="service_type_active" name="is_active" type="checkbox" value="1" checked class="h-5 w-5 border-black bg-white text-red-600">
                        <label for="service_type_active" class="raw-label !m-0">Active</label>
                    </div>
                    <button type="submit" class="raw-button">Save service</button>
                </form>
            </x-card>
        </div>

        <div id="subscriptions" class="scroll-target manual-subscription-section {{ request('create') === 'subscription' || $errors->subscription->any() ? 'is-focused' : '' }}">
        <x-card title="Add subscription manually">
            <p class="manual-subscription-intro">Enter the subscription details below. Partner, location, and service type must be registered first.</p>
            <form id="manual-subscription-form" method="POST" action="{{ route('workshops.subscriptions.store') }}" class="space-y-4">
                @csrf
                <div class="raw-form-grid">
                    <div>
                        <label class="raw-label">Partner</label>
                        <select id="subscription_partner_id" name="partner_id" required class="raw-select">
                            <option value="">Select partner</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->id }}" {{ (string) old('partner_id') === (string) $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="raw-label">Location</label>
                        <select id="subscription_location_id" name="location_id" required class="raw-select">
                            <option value="">Select location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" data-partner-id="{{ $location->partner_id }}" {{ (string) old('location_id') === (string) $location->id ? 'selected' : '' }}>{{ $location->name }} - {{ $location->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="raw-label">Service type</label>
                        <select name="service_type_id" required class="raw-select">
                            <option value="">Select service</option>
                            @foreach ($serviceTypes as $serviceType)
                                <option value="{{ $serviceType->id }}" {{ (string) old('service_type_id') === (string) $serviceType->id ? 'selected' : '' }}>{{ $serviceType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="raw-label">Contact</label>
                        <select id="subscription_contact_id" name="contact_id" class="raw-select">
                            <option value="">Select contact</option>
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}" data-partner-id="{{ $contact->partner_id }}" {{ (string) old('contact_id') === (string) $contact->id ? 'selected' : '' }}>{{ $contact->name }} - {{ $contact->partner->name ?? 'Partner' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="raw-label">Code</label>
                        <input name="subscription_code" type="text" value="{{ old('subscription_code') }}" placeholder="Example: SUB-2026-001" required class="raw-input">
                    </div>
                    <div>
                        <label class="raw-label">Status</label>
                        <select name="status" required class="raw-select">
                                @php $defaultStatus = old('status', $planDefault['status'] ?? 'pending'); @endphp
                                <option value="pending" {{ $defaultStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ $defaultStatus === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="paused" {{ $defaultStatus === 'paused' ? 'selected' : '' }}>Paused</option>
                                <option value="expired" {{ $defaultStatus === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                    </div>
                    <div>
                        <label class="raw-label">Start date</label>
                        <input name="starts_at" type="date" value="{{ old('starts_at') }}" required class="raw-input">
                    </div>
                    <div>
                        <label class="raw-label">End date</label>
                        <input name="ends_at" type="date" value="{{ old('ends_at') }}" required class="raw-input">
                    </div>
                    <div>
                        <label class="raw-label">Monthly fee</label>
                        <input name="monthly_fee" type="number" step="0.01" min="0" value="{{ old('monthly_fee', $planDefault['monthly_fee'] ?? 0) }}" required class="raw-input">
                    </div>
                </div>
                    <div>
                        <label class="raw-label">Notes</label>
                        <textarea name="notes" rows="3" class="raw-textarea">{{ old('notes', $planDefault['note'] ?? '') }}</textarea>
                    </div>
                <button type="submit" class="raw-button">Save manual subscription</button>
            </form>
        </x-card>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            <div class="raw-table-card">
                <h2 class="raw-table-title">Partners</h2>
                <div class="raw-table-wrap">
                    <table class="raw-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partners as $partner)
                                <tr>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->code }}</td>
                                    <td><span class="raw-status {{ $partner->is_active ? 'active' : 'paused' }}">{{ $partner->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="raw-actions">
                                            <details class="raw-row-toggle">
                                                <summary>Edit</summary>
                                                <div class="raw-inline-edit">
                                                    <form method="POST" action="{{ route('workshops.partners.update', $partner) }}" class="space-y-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="raw-form-grid">
                                                            <div>
                                                                <label class="raw-label">Name</label>
                                                                <input name="name" type="text" value="{{ $partner->name }}" required class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Code</label>
                                                                <input name="code" type="text" value="{{ $partner->code }}" required class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Email</label>
                                                                <input name="email" type="email" value="{{ $partner->email }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Phone</label>
                                                                <input name="phone" type="text" value="{{ $partner->phone }}" class="raw-input">
                                                            </div>
                                                            <div class="col-span-2">
                                                                <label class="raw-label">Address</label>
                                                                <textarea name="address" rows="3" class="raw-textarea">{{ $partner->address }}</textarea>
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">City</label>
                                                                <input name="city" type="text" value="{{ $partner->city }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Status</label>
                                                                <select name="is_active" class="raw-select">
                                                                    <option value="1" {{ $partner->is_active ? 'selected' : '' }}>Active</option>
                                                                    <option value="0" {{ !$partner->is_active ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="raw-button secondary">Update</button>
                                                    </form>
                                                </div>
                                            </details>
                                            <form method="POST" action="{{ route('workshops.partners.destroy', $partner) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="raw-button danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No partners available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="raw-table-card">
                <h2 class="raw-table-title">Locations</h2>
                <div class="raw-table-wrap">
                    <table class="raw-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Partner</th>
                                <th>City</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->partner->name ?? '-' }}</td>
                                    <td>{{ $location->city ?? '-' }}</td>
                                    <td>
                                        <div class="raw-actions">
                                            <details class="raw-row-toggle">
                                                <summary>Edit</summary>
                                                <div class="raw-inline-edit">
                                                    <form method="POST" action="{{ route('workshops.locations.update', $location) }}" class="space-y-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="raw-form-grid">
                                                            <div>
                                                                <label class="raw-label">Partner</label>
                                                                <select name="partner_id" class="raw-select">
                                                                    @foreach ($partners as $partner)
                                                                        <option value="{{ $partner->id }}" {{ $partner->id == $location->partner_id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Name</label>
                                                                <input name="name" type="text" value="{{ $location->name }}" required class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">City</label>
                                                                <input name="city" type="text" value="{{ $location->city }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Address</label>
                                                                <textarea name="address" rows="3" class="raw-textarea">{{ $location->address }}</textarea>
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Latitude</label>
                                                                <input name="latitude" type="number" step="0.0000001" value="{{ $location->latitude }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Longitude</label>
                                                                <input name="longitude" type="number" step="0.0000001" value="{{ $location->longitude }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Status</label>
                                                                <select name="is_active" class="raw-select">
                                                                    <option value="1" {{ $location->is_active ? 'selected' : '' }}>Active</option>
                                                                    <option value="0" {{ !$location->is_active ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="raw-button secondary">Update</button>
                                                    </form>
                                                </div>
                                            </details>
                                            <form method="POST" action="{{ route('workshops.locations.destroy', $location) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="raw-button danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No locations available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            <div class="raw-table-card">
                <h2 class="raw-table-title">Contacts</h2>
                <div class="raw-table-wrap">
                    <table class="raw-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Partner</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone ?? '-' }}</td>
                                    <td>{{ $contact->partner->name ?? '-' }}</td>
                                    <td>
                                        <div class="raw-actions">
                                            <details class="raw-row-toggle">
                                                <summary>Edit</summary>
                                                <div class="raw-inline-edit">
                                                    <form method="POST" action="{{ route('workshops.contacts.update', $contact) }}" class="space-y-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="raw-form-grid">
                                                            <div>
                                                                <label class="raw-label">Partner</label>
                                                                <select name="partner_id" class="raw-select">
                                                                    @foreach ($partners as $partner)
                                                                        <option value="{{ $partner->id }}" {{ $partner->id == $contact->partner_id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Name</label>
                                                                <input name="name" type="text" value="{{ $contact->name }}" required class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Position</label>
                                                                <input name="position" type="text" value="{{ $contact->position }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Phone</label>
                                                                <input name="phone" type="text" value="{{ $contact->phone }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Email</label>
                                                                <input name="email" type="email" value="{{ $contact->email }}" class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Primary</label>
                                                                <select name="is_primary" class="raw-select">
                                                                    <option value="1" {{ $contact->is_primary ? 'selected' : '' }}>Yes</option>
                                                                    <option value="0" {{ !$contact->is_primary ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="raw-button secondary">Update</button>
                                                    </form>
                                                </div>
                                            </details>
                                            <form method="POST" action="{{ route('workshops.contacts.destroy', $contact) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="raw-button danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No contacts available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="raw-table-card">
                <h2 class="raw-table-title">Service types</h2>
                <div class="raw-table-wrap">
                    <table class="raw-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($serviceTypes as $serviceType)
                                <tr>
                                    <td>{{ $serviceType->name }}</td>
                                    <td>{{ Str::limit($serviceType->description ?? '-', 40) }}</td>
                                    <td><span class="raw-status {{ $serviceType->is_active ? 'active' : 'paused' }}">{{ $serviceType->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <div class="raw-actions">
                                            <details class="raw-row-toggle">
                                                <summary>Edit</summary>
                                                <div class="raw-inline-edit">
                                                    <form method="POST" action="{{ route('workshops.service-types.update', $serviceType) }}" class="space-y-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="raw-form-grid">
                                                            <div>
                                                                <label class="raw-label">Name</label>
                                                                <input name="name" type="text" value="{{ $serviceType->name }}" required class="raw-input">
                                                            </div>
                                                            <div>
                                                                <label class="raw-label">Status</label>
                                                                <select name="is_active" class="raw-select">
                                                                    <option value="1" {{ $serviceType->is_active ? 'selected' : '' }}>Active</option>
                                                                    <option value="0" {{ !$serviceType->is_active ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <label class="raw-label">Description</label>
                                                                <textarea name="description" rows="3" class="raw-textarea">{{ $serviceType->description }}</textarea>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="raw-button secondary">Update</button>
                                                    </form>
                                                </div>
                                            </details>
                                            <form method="POST" action="{{ route('workshops.service-types.destroy', $serviceType) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="raw-button danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No service types available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="subscriptions-table" class="raw-table-card scroll-target">
            <h2 class="raw-table-title">Subscriptions</h2>
            <div class="raw-table-wrap">
                <table class="raw-table" data-table="subscriptions" data-status-filter="true">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Partner</th>
                            <th>Location</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Fee</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr data-status="{{ $subscription->status }}">
                                <td>{{ $subscription->subscription_code }}</td>
                                <td>{{ $subscription->partner->name ?? '-' }}</td>
                                <td>{{ $subscription->location->name ?? '-' }}</td>
                                <td>{{ $subscription->serviceType->name ?? '-' }}</td>
                                <td><span class="raw-status {{ $subscription->status }}">{{ ucfirst($subscription->status) }}</span></td>
                                <td>{{ number_format($subscription->monthly_fee, 2) }}</td>
                                <td>
                                    <div class="raw-actions">
                                        <details class="raw-row-toggle">
                                            <summary>Edit</summary>
                                            <div class="raw-inline-edit">
                                                <form method="POST" action="{{ route('workshops.subscriptions.update', $subscription) }}" class="space-y-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="raw-form-grid">
                                                        <div>
                                                            <label class="raw-label">Partner</label>
                                                            <select name="partner_id" class="raw-select">
                                                                @foreach ($partners as $partner)
                                                                    <option value="{{ $partner->id }}" {{ $partner->id == $subscription->partner_id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Location</label>
                                                            <select name="location_id" class="raw-select">
                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}" {{ $location->id == $subscription->location_id ? 'selected' : '' }}>{{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Service</label>
                                                            <select name="service_type_id" class="raw-select">
                                                                @foreach ($serviceTypes as $serviceType)
                                                                    <option value="{{ $serviceType->id }}" {{ $serviceType->id == $subscription->service_type_id ? 'selected' : '' }}>{{ $serviceType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Contact</label>
                                                            <select name="contact_id" class="raw-select">
                                                                <option value="">None</option>
                                                                @foreach ($contacts as $contact)
                                                                    <option value="{{ $contact->id }}" {{ $contact->id == $subscription->contact_id ? 'selected' : '' }}>{{ $contact->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Code</label>
                                                            <input name="subscription_code" type="text" value="{{ $subscription->subscription_code }}" required class="raw-input">
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Status</label>
                                                            <select name="status" class="raw-select">
                                                                <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="pending" {{ $subscription->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="paused" {{ $subscription->status == 'paused' ? 'selected' : '' }}>Paused</option>
                                                                <option value="expired" {{ $subscription->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Start date</label>
                                                            <input name="starts_at" type="date" value="{{ $subscription->starts_at->format('Y-m-d') }}" required class="raw-input">
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">End date</label>
                                                            <input name="ends_at" type="date" value="{{ $subscription->ends_at->format('Y-m-d') }}" required class="raw-input">
                                                        </div>
                                                        <div>
                                                            <label class="raw-label">Monthly fee</label>
                                                            <input name="monthly_fee" type="number" step="0.01" min="0" value="{{ $subscription->monthly_fee }}" required class="raw-input">
                                                        </div>
                                                        <div class="col-span-2">
                                                            <label class="raw-label">Notes</label>
                                                            <textarea name="notes" rows="3" class="raw-textarea">{{ $subscription->notes }}</textarea>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="raw-button secondary">Update</button>
                                                </form>
                                            </div>
                                        </details>
                                        <form method="POST" action="{{ route('workshops.subscriptions.destroy', $subscription) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="raw-button danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No subscriptions available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrap">
            {{ $subscriptions->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('manual-subscription-form');
            const partner = document.getElementById('subscription_partner_id');
            const location = document.getElementById('subscription_location_id');
            const contact = document.getElementById('subscription_contact_id');

            if (!form || !partner || !location || !contact) return;

            const filterOptions = (select) => {
                const selectedPartner = partner.value;
                Array.from(select.options).forEach((option, index) => {
                    if (index === 0) return;
                    const visible = !selectedPartner || option.dataset.partnerId === selectedPartner;
                    option.hidden = !visible;
                    option.disabled = !visible;
                });

                const current = select.options[select.selectedIndex];
                if (current && current.disabled) select.value = '';
            };

            const syncPartnerFields = () => {
                filterOptions(location);
                filterOptions(contact);
            };

            partner.addEventListener('change', syncPartnerFields);
            syncPartnerFields();

            const shouldFocusForm = new URLSearchParams(window.location.search).get('create') === 'subscription'
                || @json($errors->subscription->any());

            if (shouldFocusForm) {
                requestAnimationFrame(() => form.closest('#subscriptions').scrollIntoView({ behavior: 'smooth', block: 'start' }));
            }
        });
    </script>
</x-app-layout>
