@extends('layouts.app')

@section('title', 'Ringkasan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Ringkasan Tracer Study</h1>
            <p class="mt-2 text-sm text-slate-500">Indikator keterserapan dan relevansi pekerjaan alumni PENS.</p>
        </header>

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
    </div>
@endsection
