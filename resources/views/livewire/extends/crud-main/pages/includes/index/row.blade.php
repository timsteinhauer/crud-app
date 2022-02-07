<tr class="-row">
    @foreach($item as $key => $column)

        {{-- column wrapper --}}
        @includeFirst([
                $childPath .".index.column",
                $path. ".pages.includes.index.column"
                ])

    @endforeach

    @if( $viewOnlyMode === false)
            @includeFirst([
                    $childPath .".index.row-actions",
                    $path. ".pages.includes.index.row-actions"
                    ])
    @endif
</tr>
