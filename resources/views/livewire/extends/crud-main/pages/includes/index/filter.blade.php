{{-- todo filter einbauen --}}

@foreach($filterConfigs as $filterKey => $filterConfig)

    @if($filterConfig["position"] == "header")

        @includeFirst([
                        $childPath .".index.filter-". $filterConfig["type"],
                        $path. ".pages.includes.index.includes.filter-types.".$filterConfig["type"]
                        ])

    @endif
@endforeach
