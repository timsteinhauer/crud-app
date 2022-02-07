<div class="overflow-auto">

    {{--

    todo: make a sticky header :)

    --}}
    <table class="table table-bordered table-striped table-hover no-footer">

        {{--@includeFirst(['livewire.admin.'. $dataSource .'.crud.table.table-head', 'livewire.crud_base.includes.table-head'])--}}

        <tbody>
        @forelse ($items as $item)

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

    {{--@foreach($tableHead as $colName => $col)

        @if( isset($col["sorting"]) )
            @if( isset($filter[$colName]) && (!isset($filter[$colName]["no_table_head"]) || $filter[$colName]["no_table_head"] == false))
                @if( $filterFormOpen === $colName)
                    @include('livewire.crud_base.includes.filter.table-head-filter-modal')
                @endif
            @endif
        @endif

    @endforeach--}}

</div>
