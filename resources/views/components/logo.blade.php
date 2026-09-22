@props(['class' => '', 'link' => true])

@php
    $envLogo = env('MAINTENANCE_LOGO_URL');
    // check several possible filenames (user renamed file to logo.png)
    $candidates = [
        public_path('images/logo.svg'),
        public_path('images/logo.png'),
        public_path('images/car-rental-logo.svg'),
        public_path('images/car-rental-logo.png'),
        public_path('images/image-removebg-preview.png'),
    ];
    $found = null;
    foreach ($candidates as $path) {
        if (file_exists($path)) { $found = $path; break; }
    }
    if (!empty($envLogo)) {
        $src = $envLogo;
    } elseif ($found) {
        $src = asset('images/'.basename($found));
    } else {
        $src = null;
    }
    
@endphp

@if($src)
    @php $logoTag = '<img src="'.e($src).'" alt="Maintenance logo" class="logo-image '.e($class).'" loading="lazy" crossorigin="anonymous" />'; @endphp
    @if($link)
        <a href="{{ route('dashboard') }}" class="logo-link" aria-label="Go to dashboard">{!! $logoTag !!}</a>
    @else
        {!! $logoTag !!}
    @endif
@else
    @if($link)
        <a href="{{ route('dashboard') }}" class="logo-link logo-fallback {{ $class }}">Maintenance</a>
    @else
        <span class="logo-fallback {{ $class }}">Maintenance</span>
    @endif
@endif
