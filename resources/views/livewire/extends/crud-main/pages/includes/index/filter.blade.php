@foreach($filterConfigs as $filterKey => $filterConfig)

    @if($filterConfig["position"] == "header")

        @if( $filterConfig["searchable"] )
            @includeFirst([
                    $childPath .".index.filter-searchable",
                    $path. ".pages.includes.index.includes.filter-types.searchable"
                    ])
        @else
            @includeFirst([
                            $childPath .".index.filter-". $filterConfig["type"],
                            $path. ".pages.includes.index.includes.filter-types.".$filterConfig["type"]
                            ])
        @endif
    @endif
@endforeach
