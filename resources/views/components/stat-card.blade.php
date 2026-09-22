@props([
    'number' => 0,
    'label' => '',
])

<div {{ $attributes->merge(['class' => 'stat-card']) }}>
    <div class="stat-number">{{ $number }}</div>
    <div class="stat-label">{{ $label }}</div>
</div>
