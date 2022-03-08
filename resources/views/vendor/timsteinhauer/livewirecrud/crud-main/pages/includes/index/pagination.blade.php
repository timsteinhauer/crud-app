@if ($paginator["hasPages"])
    <ul class="pagination mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator["onFirstPage"])
            <li class="page-item disabled">
                <span class="page-link">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <button type="button" dusk="previousPage" class="page-link" wire:click="previousPageFix"
                        wire:loading.attr="disabled">&lsaquo;</button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator["elements"] as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span
                        class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator["currentPage"])
                        <li class="page-item active" wire:key="paginator-page-{{ $page }}">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item" wire:key="paginator-page-{{ $page }}">
                            <button type="button" class="page-link"
                                    wire:click="gotoPageFix({{ $page }})">{{ $page }}</button>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator["hasMorePages"])
            <li class="page-item">
                <button type="button" dusk="nextPage" class="page-link" wire:click="nextPageFix"
                        wire:loading.attr="disabled" rel="next">&rsaquo;
                </button>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">&rsaquo;</span>
            </li>
        @endif
    </ul>

@endif

