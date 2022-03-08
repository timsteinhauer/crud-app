<table class="table table-bordered table-striped table-hover no-footer mb-3">

    @includeFirst([
            $childPath .".index.table-head",
            $path. ".pages.includes.index.table-head"
            ])

    <tbody>
    @forelse ($items as $index => $item)

        @includeFirst([
            $childPath .".index.row",
            $path. ".pages.includes.index.row"
            ])
    @empty
        <tr>
            @if( $allowed["edit"] || $allowed["delete"] || ($useSoftDeleting && $allowed["restore"]))

                {{-- with column for actions --}}
                <td colspan="{{ count($this->tableColumns()) +1 }}" class="">
                    {{ $wordings["no_items"] ?? "Keine Daten gefunden." }}
                </td>

            @else
                <td colspan="{{ count($this->tableColumns()) }}" class="">
                    {{ $wordings["no_items"] ?? "Keine Daten gefunden." }}
                </td>
            @endif
        </tr>
    @endforelse
    </tbody>
</table>
