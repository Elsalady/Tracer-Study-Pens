@extends('layouts.app')

@section('title', 'Profil Alumni')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Profil Alumni</h1>
            <p class="mt-2 text-sm text-slate-500">Sebaran bidang pekerjaan, skala gaji, dan lokasi alumni yang bekerja.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.profil-alumni')" :filter="$filter" :opsi="$opsi" />

        @if ($data['total_bekerja'] === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-slate-600">{{ $data['total_bekerja'] }} alumni bekerja</p>

            <section class="grid gap-4 lg:grid-cols-2">
                <x-chart-card
                    title="Sebaran bidang pekerjaan"
                    canvas-id="chart-bidang-pekerjaan"
                    description="Jumlah alumni per bidang pekerjaan"
                />
                <x-chart-card
                    title="Skala gaji"
                    canvas-id="chart-skala-gaji"
                    description="Rentang gaji sesuai format kontrak data"
                />
                <x-chart-card
                    title="Kabupaten dominan"
                    canvas-id="chart-kabupaten"
                    description="10 kabupaten dengan jumlah alumni terbanyak"
                    class="lg:col-span-2"
                />
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    window.TracerCharts.profilAlumni({
        bidang: @json($data['bidang']),
        skala_gaji: @json($data['skala_gaji']),
        kabupaten_top: @json($data['kabupaten_top']),
    });
</script>
@endpush
