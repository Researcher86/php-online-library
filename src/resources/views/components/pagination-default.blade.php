@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled page-item"><span class="page-link">Назад</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Назад</a></li>
            @endif

            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</a></li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Вперед</a></li>
            @else
                <li class="disabled page-item"><span class="page-link">Вперед</span></li>
            @endif
        </ul>
    </nav>
@endif