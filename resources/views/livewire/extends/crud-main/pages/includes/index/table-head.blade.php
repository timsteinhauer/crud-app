<thead>
<tr>
    @foreach($this->tableColumns() as $colName => $col)

        @if( isset($col["sorting"]) && $col["sorting"] === true )
            <th class="-sorting {!! $col["class"] ?? '' !!}
                {{ $sortField === $colName ? '-active' : '' }}
                -sort-{{ $sortAsc ? 'asc' : 'desc'}}">
                <div>{!! $col["display"] !!}
                    <span class="sort-icon" wire:click="sortBy('{{ $colName }}')"></span>
                   {{-- @if( isset($filter[$colName]) && (!isset($filter[$colName]["no_table_head"]) || $filter[$colName]["no_table_head"] == false))
                        @include('livewire.crud_base.includes.filter.table-head-filter-btn')
                    @endif--}}
                </div>
            </th>
        @else
            <th class="{!! $col["class"] ?? '' !!}">
                <div>{!! $col["display"] !!}
                    {{--@if( isset($filter[$colName]) && (!isset($filter[$colName]["no_table_head"]) || $filter[$colName]["no_table_head"] == false))
                        @include('livewire.crud_base.includes.filter.table-head-filter-btn')
                    @endif--}}
                </div>
            </th>
        @endif

    @endforeach

    @if( $allowed["edit"] || $allowed["delete"] || $allowed["clone"] || $allowed["restore"] || $allowed["open"] )
        <th class="{{ $styling["action_column_class"] }}" style="{{ $styling["action_column_style"] }}">
            <div>Aktionen</div>
        </th>
    @endif
</tr>
</thead>
