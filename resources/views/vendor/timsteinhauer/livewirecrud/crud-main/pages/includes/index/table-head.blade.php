<thead>
<tr>
    @foreach($this->tableColumns() as $columnKey => $column)


        <th class="align-middle {{ $column["class"] ?? "" }}">
            <div class="d-flex align-items-center position-relative">
                <div>
                    {!! $column["display"] !!}
                </div>

                <div class="ml-auto d-flex ">

                    @if( $this->hasFilter($columnKey) && $allowed["show_filter"])
                        @includeFirst([
                            $childPath .".index.filter-icon",
                            $path. ".pages.includes.index.includes.filter-icon"
                            ], ["filterClass" => "pl-2"])
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

    @if( $allowed["edit"] || $allowed["delete"] || ($useSoftDeleting && $allowed["restore"]))
        <th class="align-middle {{ $styling["action_column_class"] }}" style="{{ $styling["action_column_style"] }}">
        </th>
    @endif
</tr>
</thead>
