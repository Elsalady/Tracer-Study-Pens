<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Tracer Study PENS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    @php
        $menu = [
            [
                'label' => 'Ringkasan',
                'route' => 'admin.dashboard.ringkasan',
                'icon' => '<path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>',
            ],
            [
                'label' => 'Keterserapan',
                'route' => 'admin.dashboard.keterserapan',
                'icon' => '<path d="M4 20V10m6 10V4m6 16v-7m6 7V8"/>',
            ],
            [
                'label' => 'Relevansi',
                'route' => 'admin.dashboard.relevansi',
                'icon' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/>',
            ],
            [
                'label' => 'Profil Alumni',
                'route' => 'admin.dashboard.profil-alumni',
                'icon' => '<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3 2.7-5 6-5s6 2 6 5M16 11a3 3 0 1 0-2-5.2M17 20c0-2-.8-3.5-2-4.5"/>',
            ],
            [
                'label' => 'Data Jawaban',
                'route' => 'admin.dashboard.data-jawaban',
                'icon' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M9 10v9"/>',
            ],
        ];
    @endphp

    <div class="app-shell">
        <aside id="sidebar" class="app-sidebar" aria-label="Navigasi utama">
            <div class="flex items-center gap-3 border-b border-sidebar-hover px-5 py-5">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-accent text-accent-ink">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5z"/>
                        <path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent">PENS</p>
                    <p class="text-sm font-semibold text-card">Tracer Study</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
                @auth
                    @foreach ($menu as $item)
                        <a href="{{ route($item['route']) }}"
                           class="nav-link {{ request()->routeIs($item['route']) || ($item['route'] === 'admin.dashboard.ringkasan' && request()->is('/')) ? 'is-active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $item['icon'] !!}</svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                @endauth
            </nav>

            @auth
                    <div class="border-t border-sidebar-hover px-3 py-4">
                        <div class="mb-3 flex items-center gap-3 px-2">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-primary text-sm font-semibold text-card">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs text-primary-soft">Admin</p>
                                <p class="truncate text-sm font-semibold text-card">{{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-logout">Keluar</button>
                        </form>
                    </div>
            @endauth
        </aside>

        <div id="sidebar-overlay" class="sidebar-overlay" aria-hidden="true"></div>

        <div class="app-main">
            <header class="app-topbar">
                <div class="mx-auto flex max-w-6xl items-center gap-3 px-4 py-3">
                    <button id="sidebar-toggle" type="button" class="sidebar-toggle" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="h-5 w-5" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-primary">Admin / Dashboard</p>
                        <p class="truncate text-sm font-semibold text-ink">@yield('title', 'Dashboard')</p>
                    </div>
                </div>
            </header>

            <main class="page-enter">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
