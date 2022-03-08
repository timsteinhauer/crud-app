<div class="col">
    <div class="card">
        <div class="card-body">

            @php( $first = 1)
            @foreach($this->cardLayout() as $columnKey => $headColumn)

                @if( isset($item[$columnKey]))

                    @php( $column = $item[$columnKey])

                    <div class="d-flex position-relative">

                        @if( $this->hasFilter($columnKey) && $allowed["show_filter"])
                            @includeFirst([
                                 $childPath .".index.filter-icon",
                                 $path. ".pages.includes.index.includes.filter-icon"
                                 ], ["filterClass" => "pr-2"])
                        @endif

                        @includeFirst([
                           $childPath .".index.card-row.". $columnKey,
                           $path. ".pages.includes.index.card-row"
                           ], ["first" => $first])

                    </div>

                    @php( $first = 0)
                @endif
            @endforeach
        </div>

        @if( $allowed["edit"] || $allowed["delete"] || ($useSoftDeleting && $allowed["restore"]))

            @includeFirst([
                $childPath .".index.card-actions",
                $path. ".pages.includes.index.card-actions"
                ])

        @endif
    </div>
</div>
