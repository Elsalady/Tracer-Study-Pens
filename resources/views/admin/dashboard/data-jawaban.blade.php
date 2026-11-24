@extends('layouts.app')

@section('title', 'Data Jawaban')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Data Jawaban</h1>
            <p class="mt-2 text-sm text-slate-500">Tabel mentah hasil tracer study untuk pengecekan terhadap data dummy.</p>
        </header>

        <x-filter-bar
            :action="route('admin.dashboard.data-jawaban')"
            :filter="$filter"
            :opsi="$opsi"
            :show-search="true"
        />

        @if ($jawaban->total() === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-slate-600">Menampilkan {{ $jawaban->total() }} jawaban</p>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-3">NRP</th>
                                <th class="px-3 py-3">Nama</th>
                                <th class="px-3 py-3">Prodi</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3">Perusahaan</th>
                                <th class="px-3 py-3">Bidang</th>
                                <th class="px-3 py-3 text-right">Relevansi</th>
                                <th class="px-3 py-3">Dikirim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($jawaban as $row)
                                <tr>
                                    <td class="px-3 py-2 font-mono text-xs">{{ $row->nrp }}</td>
                                    <td class="px-3 py-2">{{ $row->nama }}</td>
                                    <td class="px-3 py-2">{{ $row->prodi }}</td>
                                    <td class="px-3 py-2">{{ $row->status_kerja }}</td>
                                    <td class="px-3 py-2">{{ $row->nama_perusahaan ?? '—' }}</td>
                                    <td class="px-3 py-2">{{ $row->bidang_pekerjaan ?? '—' }}</td>
                                    <td class="px-3 py-2 text-right">{{ $row->relevansi ?? '—' }}</td>
                                    <td class="px-3 py-2">{{ $row->submitted_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="mt-4">{{ $jawaban->links() }}</div>
        @endif
    </div>
@endsection
