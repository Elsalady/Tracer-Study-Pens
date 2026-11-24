@extends('layouts.app')

@section('title', 'Relevansi')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Relevansi Pekerjaan</h1>
            <p class="mt-2 text-sm text-slate-500">Penilaian kesesuaian pekerjaan dengan bidang studi alumni yang bekerja.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.relevansi')" :filter="$filter" :opsi="$opsi" />

        @if ($data['total_dinilai'] === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-slate-600">
                {{ $data['total_dinilai'] }} penilaian · rata-rata {{ number_format($data['rata_rata'], 2, ',', '.') }} / 5 ·
                {{ number_format($data['persentase_relevan'], 1, ',', '.') }}% relevan
            </p>

            <section class="grid gap-4 lg:grid-cols-2">
                <x-chart-card
                    title="Distribusi skor relevansi"
                    canvas-id="chart-distribusi-relevansi"
                    description="Jumlah responden untuk skor 1 sampai 5"
                />
                <x-chart-card
                    title="Rata-rata relevansi per program studi"
                    canvas-id="chart-rata-relevansi-prodi"
                    description="Skala 1 sampai 5"
                />
            </section>

            <section class="mt-6 grid gap-4 lg:grid-cols-2">
                @foreach (['terbaik' => $data['bidang_terbaik'], 'terendah' => $data['bidang_terendah']] as $judul => $baris)
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <h2 class="border-b border-slate-100 px-4 py-3 text-sm font-semibold text-slate-800">
                            Bidang dengan skor {{ $judul }} (minimal {{ $data['minimum_responden'] }} responden)
                        </h2>
                        <table class="w-full text-left text-sm">
                            <thead class="text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-4 py-2">Bidang pekerjaan</th>
                                    <th class="px-4 py-2 text-right">Jumlah</th>
                                    <th class="px-4 py-2 text-right">Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($baris as $row)
                                    <tr>
                                        <td class="px-4 py-2">{{ $row['bidang'] }}</td>
                                        <td class="px-4 py-2 text-right">{{ $row['total_dinilai'] }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ number_format($row['rata_rata'], 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-slate-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    window.TracerCharts.relevansi({
        distribusi: @json($data['distribusi']),
        per_prodi: @json($data['per_prodi']),
    });
</script>
@endpush
