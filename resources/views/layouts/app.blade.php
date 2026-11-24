<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Tracer Study PENS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">PENS</p>
                    <p class="text-sm font-semibold text-slate-800">Tracer Study — Monitoring Admin</p>
                </div>
                <nav class="flex flex-wrap items-center gap-1 text-sm">
                    <a href="{{ route('admin.dashboard.ringkasan') }}" class="rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Ringkasan</a>
                    <a href="{{ route('admin.dashboard.keterserapan') }}" class="rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Keterserapan</a>
                    <a href="{{ route('admin.dashboard.relevansi') }}" class="rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Relevansi</a>
                    <a href="{{ route('admin.dashboard.profil-alumni') }}" class="rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Profil Alumni</a>
                    <a href="{{ route('admin.dashboard.data-jawaban') }}" class="rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Data Jawaban</a>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
