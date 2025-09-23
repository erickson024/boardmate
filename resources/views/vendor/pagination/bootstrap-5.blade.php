@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-md">
        
            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- Dots --}}
                @if (is_string($element))
                    <li class="page-item disabled "><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link bg-dark border border-dark ">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link shadow-none text-dark" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
     
        </ul>
    </nav>
@endif
