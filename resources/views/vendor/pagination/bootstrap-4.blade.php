@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements (Custom 4-page shifting logic) --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $pagesToShow = 4; // Number of page links to display

                // Determine the starting page number for the current block of 4
                $startPage = max(1, min($currentPage - floor(($pagesToShow - 1) / 2), $lastPage - $pagesToShow + 1));
                
                // Ensure we don't go below page 1
                if ($startPage <= 0) {
                    $startPage = 1;
                }

                // Determine the ending page number for the current block of 4
                $endPage = min($startPage + $pagesToShow - 1, $lastPage);

                // If we're at the end and don't have 4 pages, adjust startPage
                if (($endPage - $startPage + 1) < $pagesToShow && $lastPage >= $pagesToShow) {
                    $startPage = $lastPage - $pagesToShow + 1;
                }
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                @if ($i == $currentPage)
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif