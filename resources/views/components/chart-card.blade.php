@props([
    'title' => '',
    'canvasId' => '',
    'description' => null,
    'accent' => 'bg-primary',
    'stagger' => 1,
])

<section {{ $attributes->merge(['class' => "app-card page-enter stagger-{$stagger} p-5"]) }}>
    <div class="flex items-start gap-3">
        <span class="mt-2 h-1.5 w-8 shrink-0 rounded-full {{ $accent }}"></span>
        <div>
            <h2 class="text-sm font-semibold text-ink">{{ $title }}</h2>
            @if ($description)
                <p class="mt-1 text-xs text-muted">{{ $description }}</p>
            @endif
        </div>
    </div>

    {{ $legend ?? '' }}

    <div class="relative mt-4 h-64">
        <canvas id="{{ $canvasId }}"></canvas>
    </div>
</section>
