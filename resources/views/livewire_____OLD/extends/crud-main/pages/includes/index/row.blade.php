<tr class="-row">

    @foreach($this->tableColumns() as $key => $headColumn)

        @if( isset($item[$key]))
            @php( $column = $item[$key])

            {{-- column wrapper --}}
            @includeFirst([
                    $childPath .".index.column",
                    $path. ".pages.includes.index.column"
                    ])
        @else
            <td class="-column -empty"></td>
        @endif
    @endforeach

    @if( $allowed["edit"] || $allowed["delete"] || ($useSoftDeleting && $allowed["restore"]) )
        @includeFirst([
                $childPath .".index.row-actions",
                $path. ".pages.includes.index.row-actions"
                ])
    @endif
</tr>
