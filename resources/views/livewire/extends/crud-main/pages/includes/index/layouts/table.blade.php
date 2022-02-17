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
            <td {{--colspan="{{ $columnCount }}"--}} class="">
                {{ $wordings["no_items"] ?? "Keine Daten gefunden." }}
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
