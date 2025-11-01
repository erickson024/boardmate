@if ($paginator->hasPages())
<nav aria-label="Page navigation example" class="mt-4">
  <ul class="pagination pagination-sm justify-content-center">

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled"><span class="page-link  shadow-none">Previous</span></li>
    @else
      <li class="page-item"><a class="page-link  shadow-none" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="page-item active"><span class="page-link  shadow-none">{{ $page }}</span></li>
          @else
            <li class="page-item"><a class="page-link  shadow-none" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <li class="page-item"><a class="page-link shadow-none" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
    @else
      <li class="page-item disabled"><span class="page-link shadow-none">Next</span></li>
    @endif
  </ul>
</nav>

<style>
  .pagination .page-link {
    color: #f8f9fa;
    background-color: #343a40;
    border-color: #454d55;
  }
  .pagination .page-link:hover {
    background-color: #495057;
    border-color: #495057;
  }
  .pagination .page-item.active .page-link {
    background-color: #fff;
    border-color: #343a40;
    color: #343a40;
  }
  .pagination .page-item.disabled .page-link {
    background-color: #343a40;
    color: #6c757d;
    border-color: #454d55;
  }
</style>
@endif
