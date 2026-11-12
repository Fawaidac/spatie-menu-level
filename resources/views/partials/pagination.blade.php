@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="app-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="app-page-item is-disabled" aria-disabled="true" aria-label="Halaman Sebelumnya">
                <svg class="app-page-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="app-page-item" aria-label="Halaman Sebelumnya">
                <svg class="app-page-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="app-page-item is-ellipsis" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="app-page-item is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="app-page-item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="app-page-item" aria-label="Halaman Selanjutnya">
                <svg class="app-page-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
        @else
            <span class="app-page-item is-disabled" aria-disabled="true" aria-label="Halaman Selanjutnya">
                <svg class="app-page-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
        @endif
    </nav>
@endif
