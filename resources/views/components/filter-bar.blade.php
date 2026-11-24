@props([
    'action' => '',
    'filter' => [],
    'opsi' => [],
    'showSearch' => false,
])

<form method="GET" action="{{ $action }}" class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="grid gap-3 md:grid-cols-3 xl:grid-cols-6">
        <label class="text-xs font-medium text-slate-600">
            Tahun lulus
            <select name="tahun_lulus" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                <option value="">Semua</option>
                @foreach ($opsi['tahun'] ?? [] as $tahun)
                    <option value="{{ $tahun }}" {{ old('tahun_lulus', $filter['tahun_lulus'] ?? '') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-xs font-medium text-slate-600">
            Program studi
            <select name="prodi" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                <option value="">Semua</option>
                @foreach ($opsi['prodi'] ?? [] as $prodi)
                    <option value="{{ $prodi }}" {{ old('prodi', $filter['prodi'] ?? '') === $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-xs font-medium text-slate-600">
            Status kerja
            <select name="status_kerja" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                <option value="">Semua</option>
                @foreach ($opsi['status'] ?? [] as $status)
                    <option value="{{ $status }}" {{ old('status_kerja', $filter['status_kerja'] ?? '') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-xs font-medium text-slate-600">
            Dari tanggal
            <input type="date" name="dari_tanggal" value="{{ old('dari_tanggal', $filter['dari_tanggal'] ?? '') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
        </label>

        <label class="text-xs font-medium text-slate-600">
            Sampai tanggal
            <input type="date" name="sampai_tanggal" value="{{ old('sampai_tanggal', $filter['sampai_tanggal'] ?? '') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
        </label>

        @if ($showSearch)
            <label class="text-xs font-medium text-slate-600">
                Cari
                <input type="text" name="q" value="{{ old('q', $filter['q'] ?? '') }}" placeholder="NRP, nama, atau perusahaan" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
            </label>
        @endif
    </div>

    <div class="mt-4 flex items-center gap-3">
        <button type="submit" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">Terapkan</button>
        <a href="{{ $action }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">Reset</a>
    </div>
</form>
