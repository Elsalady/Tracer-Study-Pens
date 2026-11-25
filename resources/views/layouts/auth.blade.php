<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') — Tracer Study PENS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="hidden flex-col justify-between bg-primary-dark p-12 text-card lg:flex">
            <div class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-accent text-accent-ink">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5z"/>
                        <path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent">PENS</p>
                    <p class="text-lg font-semibold">Tracer Study</p>
                </div>
            </div>

            <div class="max-w-md">
                <h2 class="text-3xl font-semibold tracking-tight">Monitoring keterserapan dan relevansi alumni.</h2>
                <p class="mt-4 text-sm text-primary-soft">Satu tampilan untuk indikator tracer study alumni Politeknik Elektronika Negeri Surabaya.</p>
            </div>

            <p class="text-xs text-primary-soft">Dashboard Admin · Tracer Study PENS</p>
        </div>

        <main class="page-enter flex min-h-screen flex-col items-center justify-center bg-surface px-4 py-8 sm:py-12">
            <div class="mb-5 w-full max-w-md min-w-0 lg:hidden">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-primary text-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5z"/>
                            <path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-primary">PENS</p>
                        <p class="truncate text-sm font-semibold text-ink">Tracer Study</p>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
