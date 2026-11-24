@extends('layouts.app')

@section('title', 'Ringkasan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Ringkasan Tracer Study</h1>
            <p class="mt-2 text-sm text-slate-500">Indikator keterserapan dan relevansi pekerjaan alumni PENS.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.ringkasan')" :filter="$filter" :opsi="$opsi" />

        @if ($kpi['total_responden'] === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Tidak ada data
            </div>
        @else
            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Kartu indikator">
                <x-kpi-card
                    label="Total responden"
                    :value="$kpi['label_total_responden']"
                    hint="Jumlah jawaban tracer yang masuk"
                />
                <x-kpi-card
                    label="Tingkat keterserapan"
                    :value="$kpi['label_tingkat_keterserapan']"
                    :hint="$kpi['total_bekerja'].' dari '.$kpi['total_responden'].' responden bekerja'"
                />
                <x-kpi-card
                    label="Rata-rata relevansi"
                    :value="$kpi['label_rata_rata_relevansi'].' / 5'"
                    hint="Dari alumni dengan status bekerja"
                />
                <x-kpi-card
                    label="Persentase relevan"
                    :value="$kpi['label_persentase_relevan']"
                    :hint="$kpi['total_relevan'].' dari '.$kpi['total_dinilai'].' penilaian relevansi'"
                />
            </section>

            <section class="mt-6 grid gap-4 lg:grid-cols-2">
                <x-chart-card
                    title="Tren keterserapan per tahun lulus"
                    canvas-id="chart-tren-keterserapan"
                    description="Persentase alumni bekerja per tahun lulus"
                />
                <x-chart-card
                    title="Komposisi status kerja"
                    canvas-id="chart-komposisi-status"
                    description="Jumlah responden berdasarkan status kerja"
                />
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    window.TracerCharts.ringkasan({
        tren: @json($kpi['tren']),
        komposisi: @json($kpi['komposisi']),
    });
</script>
@endpush
