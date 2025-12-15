@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" role="navigation">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
.pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.375rem;
    --bs-pagination-hover-color: #4361ee;
    --bs-pagination-hover-bg: #f8f9fa;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #4361ee;
    --bs-pagination-focus-bg: #f8f9fa;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #4361ee;
    --bs-pagination-active-border-color: #4361ee;
    --bs-pagination-disabled-color: #adb5bd;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
}

.pagination .page-link {
    transition: all 0.2s ease-in-out;
}

.pagination .page-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
    border-color: #4361ee;
    box-shadow: 0 2px 4px rgba(67, 97, 238, 0.3);
}
</style>