@props([
    'title' => '',
    'canvasId' => '',
    'description' => null,
])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="text-sm font-semibold text-slate-800">{{ $title }}</h2>
    @if ($description)
        <p class="mt-1 text-xs text-slate-500">{{ $description }}</p>
    @endif
    <div class="relative mt-4 h-64">
        <canvas id="{{ $canvasId }}"></canvas>
    </div>
</section>
