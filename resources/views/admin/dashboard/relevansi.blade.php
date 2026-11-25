@extends('layouts.app')

@section('title', 'Relevansi')

@section('content')
    @php
        $akunBidang = [
            'terbaik' => 'bg-status-bekerja',
            'terendah' => 'bg-status-wirausaha',
        ];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10">
        <header class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-ink">Relevansi Pekerjaan</h1>
            <p class="mt-2 text-sm text-muted">Penilaian kesesuaian pekerjaan dengan bidang studi alumni yang bekerja.</p>
        </header>

        <x-filter-bar :action="route('admin.dashboard.relevansi')" :filter="$filter" :opsi="$opsi" />

        @if ($data['total_dinilai'] === 0)
            <div class="app-card page-enter border-dashed p-10 text-center text-sm text-muted">
                Tidak ada data
            </div>
        @else
            <p class="mb-4 text-sm font-medium text-muted">
                {{ $data['total_dinilai'] }} penilaian · rata-rata {{ number_format($data['rata_rata'], 2, ',', '.') }} / 5 ·
                {{ number_format($data['persentase_relevan'], 1, ',', '.') }}% relevan
            </p>

            <section class="grid gap-4 lg:grid-cols-2">
                <x-chart-card
                    title="Distribusi skor relevansi"
                    canvas-id="chart-distribusi-relevansi"
                    description="Jumlah responden untuk skor 1 sampai 5"
                    accent="bg-primary"
                    :stagger="1"
                />
                <x-chart-card
                    title="Rata-rata relevansi per program studi"
                    canvas-id="chart-rata-relevansi-prodi"
                    description="Skala 1 sampai 5"
                    accent="bg-status-kuliah"
                    :stagger="2"
                />
            </section>

            <section class="mt-6 grid gap-4 lg:grid-cols-2">
                @foreach (['terbaik' => $data['bidang_terbaik'], 'terendah' => $data['bidang_terendah']] as $judul => $baris)
                    <div class="app-card page-enter overflow-hidden stagger-{{ $loop->iteration + 2 }}">
                        <div class="flex items-center gap-3 border-b border-line px-4 py-3">
                            <span class="h-1.5 w-6 rounded-full {{ $akunBidang[$judul] }}"></span>
                            <h2 class="text-sm font-semibold text-ink">
                                Bidang dengan skor {{ $judul }} (minimal {{ $data['minimum_responden'] }} responden)
                            </h2>
                        </div>
                        <div class="table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Bidang pekerjaan</th>
                                        <th class="px-4 py-2 text-right">Jumlah</th>
                                        <th class="px-4 py-2 text-right">Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($baris as $row)
                                        <tr>
                                            <td class="px-4 py-2">{{ $row['bidang'] }}</td>
                                            <td class="px-4 py-2 text-right">{{ $row['total_dinilai'] }}</td>
                                            <td class="px-4 py-2 text-right font-semibold text-primary">{{ number_format($row['rata_rata'], 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-4 text-center text-muted">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
