@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="w-full min-w-0 max-w-md">
        <div class="app-card p-5 sm:p-8">
            <h1 class="text-xl font-semibold tracking-tight text-ink sm:text-2xl">Masuk ke Dashboard</h1>
            <p class="mt-1 text-sm text-muted">Monitoring keterserapan dan relevansi alumni PENS.</p>

            @if ($errors->any())
                <div class="auth-error mt-4 space-y-1" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                <div class="min-w-0">
                    <label for="email" class="text-xs font-medium text-muted sm:text-sm">Email</label>
                    <div class="relative mt-1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute start-3 top-1/2 h-4 w-4 -translate-y-1/2 text-subtle" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="m3 7 9 6 9-6"/>
                        </svg>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" autofocus required class="auth-field ps-11">
                    </div>
                </div>

                <div class="min-w-0">
                    <label for="password" class="text-xs font-medium text-muted sm:text-sm">Kata sandi</label>
                    <div class="relative mt-1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute start-3 top-1/2 h-4 w-4 -translate-y-1/2 text-subtle" aria-hidden="true">
                            <rect x="4" y="10" width="16" height="10" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        </svg>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="auth-field ps-11">
                        <button type="button" class="auth-password-toggle" aria-controls="password" aria-pressed="false" aria-label="Tampilkan kata sandi" data-password-toggle>
                            <svg data-icon-show viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg data-icon-hide viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="hidden" aria-hidden="true">
                                <path d="M3 3 21 21"/>
                                <path d="M10.6 10.6a3 3 0 0 0 4.2 4.2"/>
                                <path d="M9.9 4.24A9.8 9.8 0 0 1 12 4c5.5 0 9.5 6 9.5 6a15.6 15.6 0 0 1-2.4 3.1M6.6 6.6C4.2 8.2 2.5 10 2.5 10s4 6 9.5 6c1.2 0 2.3-.2 3.3-.6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary auth-submit w-full">
                    Masuk
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const input = document.getElementById(button.getAttribute('aria-controls'));
            const eye = button.querySelector('[data-icon-show]');
            const eyeOff = button.querySelector('[data-icon-hide]');
            if (!input || !eye || !eyeOff) return;

            const update = (visible) => {
                input.type = visible ? 'text' : 'password';
                eye.classList.toggle('hidden', visible);
                eyeOff.classList.toggle('hidden', !visible);
                button.setAttribute('aria-pressed', String(visible));
                button.setAttribute('aria-label', visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            };

            button.addEventListener('click', () => update(input.type === 'password'));
        });
    });
</script>
@endpush
