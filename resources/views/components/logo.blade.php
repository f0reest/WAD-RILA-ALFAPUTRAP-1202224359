@props(['class' => '', 'link' => true])

@if ($link)
    <a href="{{ route('dashboard') }}" class="logo-link" aria-label="Go to dashboard">
        <img src="{{ asset('images/logo.png') }}" alt="Maintenance" class="logo-image {{ $class }}" width="160" height="48">
    </a>
@else
    <img src="{{ asset('images/logo.png') }}" alt="Maintenance" class="logo-image {{ $class }}" width="160" height="48">
@endif
