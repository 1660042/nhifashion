@if (count($paginator) > 0 && $paginator->lastPage() > 1)
    <nav aria-label="Page navigation">
        <ul class="pagination">

            {{-- Prev page --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" data-page="{{ $paginator->currentPage() - 1 }}"
                        href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </a>
                </li>
            @endif

            {{-- Page number --}}

            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @endfor

            @foreach (range(1, $paginator->lastPage()) as $i)
                @if ($i >= $paginator->currentPage() - 4 && $i <= $paginator->currentPage() + 4)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" data-page="{{ $i }}"
                                href=" {{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" data-page="{{ $i }}"
                                href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach

            {{-- Next page --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" data-page="{{ $paginator->currentPage() + 1 }}"
                        href="{{ $paginator->nextPageUrl() }}">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
@endif
