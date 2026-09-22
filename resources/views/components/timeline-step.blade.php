@props([
    'index' => null,
    'title' => null,
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'timeline-step']) }}>
    @if($icon)
        <div class="step-icon">{!! $icon !!}</div>
    @endif
    <div class="step-index">{{ $index ?? '•' }}</div>
    <div class="step-card">
        <h3 class="step-title">{{ $title ?? 'Step' }}</h3>
        <p class="step-desc">{{ $description ?? $slot }}</p>
    </div>
</div>
