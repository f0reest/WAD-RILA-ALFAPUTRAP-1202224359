@props([
    'title' => null,
    'price' => null,
    'features' => null,
    'ctaText' => null,
    'ctaHref' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'pricing-card']) }}>
    <div class="pricing-head">
        <div class="pricing-icon">
            @if(isset($icon))
                {!! $icon !!}
            @else
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M3 12h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 3v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            @endif
        </div>
        <h3>{{ $title ?? 'Starter' }}</h3>
        <div class="pricing-price">{{ $price ?? 'Free' }}</div>
    </div>
    <ul class="pricing-features">
        @if(isset($features) && is_array($features))
            @foreach($features as $feat)
                <li>{{ $feat }}</li>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </ul>
    @if(isset($ctaText))
        <div class="pricing-cta">
            <a href="{{ $ctaHref ?? '#' }}" class="btn btn-primary">{{ $ctaText }}</a>
        </div>
    @endif
</div>
</div>
