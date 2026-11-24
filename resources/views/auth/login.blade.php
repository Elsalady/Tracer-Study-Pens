@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="mx-auto max-w-md px-4 py-16">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-xl font-semibold text-slate-900">Masuk ke Dashboard</h1>
            <p class="mt-1 text-sm text-slate-500">Monitoring keterserapan dan relevansi alumni PENS.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="email" class="text-xs font-medium text-slate-600">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" autofocus class="mt-1 w-full rounded-lg border-slate-300 text-sm" required>
                </div>

                <div>
                    <label for="password" class="text-xs font-medium text-slate-600">Kata sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" class="mt-1 w-full rounded-lg border-slate-300 text-sm" required>
                </div>

                <button type="submit" class="w-full rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">Masuk</button>
            </form>
        </div>
    </div>
@endsection
