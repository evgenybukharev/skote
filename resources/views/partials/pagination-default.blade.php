@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-rounded justify-content-end mb-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled page-item" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item" aria-current="page"><a class="page-link" href="javascript: void(0);">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
