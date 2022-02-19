<thead>
<tr>
    @foreach($this->tableColumns() as $columnKey => $column)


        <th class="align-middle {{ $column["class"] ?? "" }}">
            <div class="d-flex align-items-center position-relative">
                <div>
                    {!! $column["display"] !!}
                </div>

                <div class="ml-auto d-flex ">

                    @if( $this->hasFilter($columnKey))
                        <div class="pl-2 cursor-pointer hover:opacity-50" wire:click="$set('openedFilterModal', '{{ $openedFilterModal == $columnKey ? "" : $columnKey }}')">
                            <i class="bi bi-funnel{{ $this->isFilterActive($columnKey) ? "-fill ". $styling["filter_active_color"] : "" }}"></i>
                        </div>

                        @if( $openedFilterModal == $columnKey)
                            <div class="position-absolute p-2 border  border-dark bg-white overflow-hidden shadow-2xl sm:rounded-lg top-100 right-0 w-100"
                            style="box-shadow: 0px 3px 15px 5px !important;">

                                <button class="btn btn-sm btn-close position-absolute"
                                        style="top: 10px; right: 6px;"
                                        wire:click="$set('openedFilterModal', '')"></button>

                                @php( $tmp = $this->getFilterConfigAtPosition($columnKey) )
                                @php( $filterConfig = $tmp["filterConfig"] )
                                @php( $filterKey = $tmp["filterKey"] )

                                @includeFirst([
                                    $childPath .".index.filter-". $filterConfig["type"],
                                    $path. ".pages.includes.index.includes.filter-types.".$filterConfig["type"]
                                    ])

                            </div>
                        @endif
                    @endif

                    @if( isset($column["sorting"]) && $column["sorting"] === true )
                        <div class="pl-2 cursor-pointer hover:opacity-50" wire:click="sortBy('{{ $columnKey }}')">
                            <i class="bi bi-sort-alpha-down{{ $sortAsc ? "" : "-alt" }}"></i>
                        </div>
                    @endif
                </div>
                {{-- @if( isset($filter[$colName]) && (!isset($filter[$colName]["no_table_head"]) || $filter[$colName]["no_table_head"] == false))
                     @include('livewire.crud_base.includes.filter.table-head-filter-btn')
                 @endif--}}
            </div>
        </th>

    @endforeach

    @if( $allowed["edit"] || $allowed["delete"] || $allowed["clone"] || $allowed["restore"] || $allowed["open"] )
        <th class="align-middle {{ $styling["action_column_class"] }}" style="{{ $styling["action_column_style"] }}">
        </th>
    @endif
</tr>
</thead>
