@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="pagination mt-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs text-muted">
                Menampilkan {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} hasil
            </p>

            <div class="flex flex-wrap items-center gap-1.5">
                @if ($paginator->onFirstPage())
                    <span class="page-btn is-disabled" aria-disabled="true">Sebelumnya</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-btn">Sebelumnya</a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="page-ellipsis px-2 text-sm text-subtle">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="page-btn is-active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-btn">Berikutnya</a>
                @else
                    <span class="page-btn is-disabled" aria-disabled="true">Berikutnya</span>
                @endif
            </div>
        </div>
    </nav>
@endif
