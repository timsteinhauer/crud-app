<div class="{{ $filterClass ?? "" }} pr-2 cursor-pointer hover:opacity-50"
     wire:click="$set('openedFilterModal', '{{ $openedFilterModal == $columnKey ? "" : $columnKey. ($index ?? "") }}')">
    <i class="bi bi-funnel{{ $this->isFilterActive($columnKey) ? "-fill ". $styling["filter_active_color"] : "" }}"></i>
</div>

@if( $openedFilterModal == $columnKey. ($index ?? ""))
    <div
        class="position-absolute z-10 p-2 border  border-dark bg-white overflow-hidden shadow-2xl sm:rounded-lg top-100 right-0 w-100"
        style="box-shadow: 0px 3px 15px 5px !important;">

        <button class="btn btn-sm btn-close position-absolute"
                style="top: 10px; right: 6px;"
                wire:click="$set('openedFilterModal', '')"></button>

        @php
            $tmp = $this->getFilterConfigAtPosition($columnKey);
            $filterConfig = $tmp["filterConfig"];
            $filterKey = $tmp["filterKey"];
        @endphp

        @includeFirst([
            $childPath .".index.filter-". $filterConfig["type"],
            $path. ".pages.includes.index.includes.filter-types.".$filterConfig["type"]
            ])

    </div>
@endif

