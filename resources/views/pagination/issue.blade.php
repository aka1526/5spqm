
    @if ($paginator->hasPages())
     <nav aria-label="Page navigation">
      {{-- Previous Page Link --}}




      {{-- Pagination Elements --}}
      <ul class="pagination">
        @if ($paginator->onFirstPage())
        <li class="page-item "><a class="page-link" disabled>Previous</a></li>
        @else
        <li class="page-item text-primary"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif

        @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
          <li><span class="pagination-ellipsis">&hellip;</span></li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
              <li class="page-item active"><a class="page-link is-current" aria-label="Goto page {{ $page }}">{{ $page }}</a></li>
              @else
              <li class="page-item "><a href="{{ $url.'&SEARCH='.($search ?? request()->search) .''.'&TAB='.($search ?? request()->tab)  }}" class="page-link" aria-label="Goto page {{ $page }}">{{ $page }}</a></li>
              @endif
            @endforeach
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item text-primary"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next Page</a></li>
        @else
        <li class="page-item "><a class="page-link" disabled>Next Page</a></li>
        @endif
      </ul>

    </nav>
    @endif
