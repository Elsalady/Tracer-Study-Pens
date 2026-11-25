@extends('layouts.app')

@section('title', 'Keterserapan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-ink">Keterserapan Alumni</h1>
            <p class="mt-2 text-sm text-muted">Perbandingan alumni bekerja terhadap jumlah responden per program studi.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.keterserapan')" :filter="$filter" :opsi="$opsi" />

        @if ($data['total_responden'] === 0)
            <div class="app-card page-enter border-dashed p-10 text-center text-sm text-muted">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-muted">
                {{ $data['total_bekerja'] }} dari {{ $data['total_responden'] }} responden bekerja ({{ $data['label_persentase'] }})
            </p>

            <x-chart-card
                title="Keterserapan per program studi"
                canvas-id="chart-keterserapan-prodi"
                description="Persentase alumni bekerja pada setiap program studi"
                accent="bg-primary"
                :stagger="1"
            />

            <section class="app-card page-enter mt-6 overflow-hidden stagger-2">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Program studi</th>
                                <th class="px-4 py-3 text-right">Responden</th>
                                <th class="px-4 py-3 text-right">Bekerja</th>
                                <th class="px-4 py-3 text-right">Keterserapan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['per_prodi'] as $row)
                                <tr>
                                    <td class="px-4 py-3">{{ $row['prodi'] }}</td>
                                    <td class="px-4 py-3 text-right">{{ $row['total_responden'] }}</td>
                                    <td class="px-4 py-3 text-right">{{ $row['total_bekerja'] }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-primary">{{ number_format($row['persentase'], 1, ',', '.') }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    window.TracerCharts.keterserapan({ per_prodi: @json($data['per_prodi']) });
</script>
@endpush
