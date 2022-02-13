<div class="-index-wrapper">



        {{--

        todo: make a sticky header :)

        --}}
        @includeFirst([
                    $childPath .".index.header",
                    $path. ".pages.includes.index.header"
                    ])

        @include($path. ".pages.includes.index.layouts.". $indexLayout)

        @includeFirst([
                    $childPath .".index.footer",
                    $path. ".pages.includes.index.footer"
                    ])



        {{-- todo filter bauen --}}
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
