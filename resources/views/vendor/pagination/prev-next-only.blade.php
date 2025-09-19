@if ($paginator->hasPages())
    <nav class="pagination-wrapper" role="navigation">
        <ul class="pagination">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item previous">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
                </li>
            @endif


            <li class="page-item page-indicator">
                <span class="page-link">
                    Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
                </span>
            </li>


            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
