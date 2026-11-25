@props([
    'action' => '',
    'filter' => [],
    'opsi' => [],
    'showSearch' => false,
])

<form method="GET" action="{{ $action }}" class="app-card filter-card mb-6 p-4">
    <div class="grid gap-3 md:grid-cols-3 xl:grid-cols-6">
        <label class="filter-label">
            Tahun lulus
            <select name="tahun_lulus" class="form-field mt-1">
                <option value="">Semua</option>
                @foreach ($opsi['tahun'] ?? [] as $tahun)
                    <option value="{{ $tahun }}" {{ old('tahun_lulus', $filter['tahun_lulus'] ?? '') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
            </select>
        </label>

        <label class="filter-label">
            Program studi
            <select name="prodi" class="form-field mt-1">
                <option value="">Semua</option>
                @foreach ($opsi['prodi'] ?? [] as $prodi)
                    <option value="{{ $prodi }}" {{ old('prodi', $filter['prodi'] ?? '') === $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                @endforeach
            </select>
        </label>

        <label class="filter-label">
            Status kerja
            <select name="status_kerja" class="form-field mt-1">
                <option value="">Semua</option>
                @foreach ($opsi['status'] ?? [] as $status)
                    <option value="{{ $status }}" {{ old('status_kerja', $filter['status_kerja'] ?? '') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </label>

        <label class="filter-label">
            Dari tanggal
            <input type="date" name="dari_tanggal" value="{{ old('dari_tanggal', $filter['dari_tanggal'] ?? '') }}" class="form-field mt-1">
        </label>

        <label class="filter-label">
            Sampai tanggal
            <input type="date" name="sampai_tanggal" value="{{ old('sampai_tanggal', $filter['sampai_tanggal'] ?? '') }}" class="form-field mt-1">
        </label>

        @if ($showSearch)
            <label class="filter-label">
                Cari
                <input type="text" name="q" value="{{ old('q', $filter['q'] ?? '') }}" placeholder="Cari..." title="Cari berdasarkan NRP, nama, atau perusahaan" class="form-field mt-1">
            </label>
        @endif
    </div>

    <div class="mt-4 flex items-center gap-3">
        <button type="submit" class="btn-primary">Terapkan</button>
        <a href="{{ $action }}" class="btn-reset">Reset</a>
    </div>
</form>
