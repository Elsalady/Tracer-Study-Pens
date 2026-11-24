@extends('layouts.app')

@section('title', 'Keterserapan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600">Admin / Dashboard</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Keterserapan Alumni</h1>
            <p class="mt-2 text-sm text-slate-500">Perbandingan alumni bekerja terhadap jumlah responden per program studi.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.keterserapan')" :filter="$filter" :opsi="$opsi" />

        @if ($data['total_responden'] === 0)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-slate-600">
                {{ $data['total_bekerja'] }} dari {{ $data['total_responden'] }} responden bekerja ({{ $data['label_persentase'] }})
            </p>

            <x-chart-card
                title="Keterserapan per program studi"
                canvas-id="chart-keterserapan-prodi"
                description="Persentase alumni bekerja pada setiap program studi"
            />

            <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Program studi</th>
                            <th class="px-4 py-3 text-right">Responden</th>
                            <th class="px-4 py-3 text-right">Bekerja</th>
                            <th class="px-4 py-3 text-right">Keterserapan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($data['per_prodi'] as $row)
                            <tr>
                                <td class="px-4 py-3">{{ $row['prodi'] }}</td>
                                <td class="px-4 py-3 text-right">{{ $row['total_responden'] }}</td>
                                <td class="px-4 py-3 text-right">{{ $row['total_bekerja'] }}</td>
                                <td class="px-4 py-3 text-right font-medium">{{ number_format($row['persentase'], 1, ',', '.') }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    window.TracerCharts.keterserapan({ per_prodi: @json($data['per_prodi']) });
</script>
@endpush
