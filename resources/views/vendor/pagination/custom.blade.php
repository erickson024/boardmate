@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center mt-4" aria-label="Page navigation">
        <ul class="pagination" style="gap: 0.5rem; list-style: none; margin: 0; padding: 0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="page-link" style="background-color: #f3f4f6; color: #d1d5db; border: 1px solid #e5e7eb; padding: 0.5rem 0.75rem; cursor: not-allowed; border-radius: 8px; font-size: 0.875rem; font-weight: 500;">← Prev</span>
                </li>
            @else
                <li>
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" style="background-color: #1f2937; color: #f9fafb; border: 1px solid #1f2937; padding: 0.5rem 0.75rem; cursor: pointer; border-radius: 8px; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#111827'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';" onmouseout="this.style.backgroundColor='#1f2937'; this.style.boxShadow='none';">← Prev</button>
                </li>
            @endif

            {{-- Page Links --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span style="padding: 0.5rem 0.5rem; color: #9ca3af;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="background-color: #000; color: #fff; border: 1px solid #000; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; display: inline-block; min-width: 2.25rem; text-align: center;">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" style="background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; padding: 0.5rem 0.75rem; cursor: pointer; border-radius: 8px; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; min-width: 2.25rem;" onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.05)';" onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.boxShadow='none';">{{ $page }}</button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" style="background-color: #1f2937; color: #f9fafb; border: 1px solid #1f2937; padding: 0.5rem 0.75rem; cursor: pointer; border-radius: 8px; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#111827'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';" onmouseout="this.style.backgroundColor='#1f2937'; this.style.boxShadow='none';">Next →</button>
                </li>
            @else
                <li>
                    <span class="page-link" style="background-color: #f3f4f6; color: #d1d5db; border: 1px solid #e5e7eb; padding: 0.5rem 0.75rem; cursor: not-allowed; border-radius: 8px; font-size: 0.875rem; font-weight: 500;">Next →</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
