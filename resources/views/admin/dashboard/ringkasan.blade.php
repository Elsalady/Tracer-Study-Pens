@extends('layouts.app')

@section('title', 'Ringkasan')

@section('content')
    @php
        $statusLabel = [
            'BEKERJA' => 'Bekerja',
            'KULIAH_LANJUT' => 'Kuliah Lanjut',
            'WIRAUSAHA' => 'Wirausaha',
            'BELUM_BEKERJA' => 'Belum Bekerja',
        ];

        $statusWarna = [
            'BEKERJA' => 'bg-status-bekerja',
            'KULIAH_LANJUT' => 'bg-status-kuliah',
            'WIRAUSAHA' => 'bg-status-wirausaha',
            'BELUM_BEKERJA' => 'bg-status-belum',
        ];

        $ikon = [
            'responden' => '<path d="M4 6h16v12H4zM4 10h16M8 15h4"/>',
            'keterserapan' => '<path d="M5 20V10m7 10V4m7 16v-7"/>',
            'relevansi' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/>',
            'relevan' => '<path d="m5 13 4 4L19 7"/>',
        ];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-ink">Ringkasan Tracer Study</h1>
            <p class="mt-2 text-sm text-muted">Indikator keterserapan dan relevansi pekerjaan alumni PENS.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.ringkasan')" :filter="$filter" :opsi="$opsi" />

        @if ($kpi['total_responden'] === 0)
            <div class="app-card page-enter border-dashed p-10 text-center text-sm text-muted">
                Tidak ada data
            </div>
        @else
            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Kartu indikator">
                <x-kpi-card
                    label="Total responden"
                    :value="$kpi['label_total_responden']"
                    hint="Jumlah jawaban tracer yang masuk"
                    :icon="$ikon['responden']"
                    accent="bg-primary"
                    :stagger="1"
                />
                <x-kpi-card
                    label="Tingkat keterserapan"
                    :value="$kpi['label_tingkat_keterserapan']"
                    :hint="$kpi['total_bekerja'].' dari '.$kpi['total_responden'].' responden bekerja'"
                    :icon="$ikon['keterserapan']"
                    accent="bg-status-bekerja"
                    :stagger="2"
                />
                <x-kpi-card
                    label="Rata-rata relevansi"
                    :value="$kpi['label_rata_rata_relevansi'].' / 5'"
                    hint="Dari alumni dengan status bekerja"
                    :icon="$ikon['relevansi']"
                    accent="bg-status-kuliah"
                    :stagger="3"
                />
                <x-kpi-card
                    label="Persentase relevan"
                    :value="$kpi['label_persentase_relevan']"
                    :hint="$kpi['total_relevan'].' dari '.$kpi['total_dinilai'].' penilaian relevansi'"
                    :icon="$ikon['relevan']"
                    accent="bg-status-wirausaha"
                    :stagger="4"
                />
            </section>

            <section class="mt-6 grid gap-4 lg:grid-cols-2">
                <x-chart-card
                    title="Tren keterserapan per tahun lulus"
                    canvas-id="chart-tren-keterserapan"
                    description="Persentase alumni bekerja per tahun lulus"
                    accent="bg-primary"
                    :stagger="5"
                />
                <x-chart-card
                    title="Komposisi status kerja"
                    canvas-id="chart-komposisi-status"
                    description="Jumlah responden berdasarkan status kerja"
                    accent="bg-status-bekerja"
                    :stagger="6"
                >
                    @slot('legend')
                        <ul class="mt-4 grid grid-cols-2 gap-2 text-xs">
                            @foreach ($kpi['komposisi'] as $row)
                                <li class="flex items-center justify-between gap-2 rounded-lg bg-surface px-2.5 py-2">
                                    <span class="flex items-center gap-2 text-muted">
                                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusWarna[$row['status']] ?? 'bg-subtle' }}"></span>
                                        {{ $statusLabel[$row['status']] ?? $row['status'] }}
                                    </span>
                                    <span class="font-semibold text-ink">{{ $row['jumlah'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endslot
                </x-chart-card>
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
