@extends('layouts.app')

@section('title', 'Data Jawaban')

@section('content')
    @php
        $statusChip = [
            'BEKERJA' => 'status-bekerja',
            'KULIAH_LANJUT' => 'status-kuliah',
            'WIRAUSAHA' => 'status-wirausaha',
            'BELUM_BEKERJA' => 'status-belum',
        ];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-ink">Data Jawaban</h1>
            <p class="mt-2 text-sm text-muted">Tabel mentah hasil tracer study untuk pengecekan terhadap data dummy.</p>
        </header>

        <x-filter-bar
            :action="route('admin.dashboard.data-jawaban')"
            :filter="$filter"
            :opsi="$opsi"
            :show-search="true"
        />

        @if ($jawaban->total() === 0)
            <div class="app-card page-enter border-dashed p-10 text-center text-sm text-muted">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-muted">Menampilkan {{ $jawaban->total() }} jawaban</p>

            <section class="app-card page-enter overflow-hidden">
                <div class="table-wrap">
                    <table class="data-table data-table--wide">
                        <thead>
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
                        <tbody>
                            @foreach ($jawaban as $row)
                                <tr>
                                    <td class="px-3 py-2 font-mono text-xs text-muted">{{ $row->nrp }}</td>
                                    <td class="px-3 py-2 font-medium">{{ $row->nama }}</td>
                                    <td class="px-3 py-2">{{ $row->prodi }}</td>
                                    <td class="px-3 py-2">
                                        <span class="status-chip {{ $statusChip[$row->status_kerja] ?? 'status-belum' }}">{{ $row->status_kerja }}</span>
                                    </td>
                                    <td class="px-3 py-2">{{ $row->nama_perusahaan ?? '—' }}</td>
                                    <td class="px-3 py-2">{{ $row->bidang_pekerjaan ?? '—' }}</td>
                                    <td class="px-3 py-2 text-right">{{ $row->relevansi ?? '—' }}</td>
                                    <td class="px-3 py-2 text-muted">{{ $row->submitted_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{ $jawaban->links() }}
        @endif
    </div>
@endsection
