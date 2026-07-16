@if ($paginator->hasPages())
    <nav class="pager">
        @if ($paginator->onFirstPage())
            <span class="pager-link disabled">&laquo; Previous</span>
        @else
            <a class="pager-link" href="{{ $paginator->previousPageUrl() }}">&laquo; Previous</a>
        @endif

        <span class="pager-status">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="pager-link" href="{{ $paginator->nextPageUrl() }}">Next &raquo;</a>
        @else
            <span class="pager-link disabled">Next &raquo;</span>
        @endif
    </nav>
@endif
