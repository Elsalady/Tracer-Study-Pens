@props([
    'label' => '',
    'value' => '',
    'hint' => null,
    'icon' => '',
    'accent' => 'bg-primary',
    'stagger' => 1,
])

<div class="app-card page-enter stagger-{{ $stagger }} p-5">
    <div class="flex items-start justify-between gap-3">
        <p class="text-sm font-medium text-muted">{{ $label }}</p>
        @if ($icon)
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl {{ $accent }} text-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">{!! $icon !!}</svg>
            </span>
        @endif
    </div>
    <p class="mt-2 text-3xl font-semibold tracking-tight text-ink" data-count="{{ $value }}">{{ $value }}</p>
    @if ($hint)
        <p class="mt-2 text-xs text-subtle">{{ $hint }}</p>
    @endif
</div>
