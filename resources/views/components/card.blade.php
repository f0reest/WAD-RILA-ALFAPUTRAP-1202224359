@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'raw-form-card']) }}>
    @if($title)
        <div class="card-header" style="display:flex;align-items:baseline;justify-content:space-between;gap:0.6rem;">
            <div>
                <h3 class="raw-form-title">{{ $title }}</h3>
                @if($subtitle)
                    <div class="text-sm text-muted">{{ $subtitle }}</div>
                @endif
            </div>
            <div class="card-actions">{{ $header ?? '' }}</div>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
