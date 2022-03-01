<div class=" pr-3">


    <label for="filter-{{ $filterKey }}" class="form-text pr-4">{{ $filterConfig["title"] }}</label>

    <div class="input-group position-relative">

        @if($openedSearchableField == $filterKey)

            <input type="text"
                   class="form-control"
                   wire:model.debounce.500ms="searchableFieldQuery"
                   placeholder="Search">

            <div class="mt-1 overflow-auto border position-absolute top-100 bg-white shadow-xl rounded w-100 z-10"
                 style="max-height: 100px">
                <div class="cursor-pointer bg-gray-200 border-b px-3 py-1 d-flex"
                     wire:click="closeSearchableField()">
                    Filter zuklappen <i class="bi bi-x ml-auto"></i>
                </div>
                @php($found = false)
                @foreach($filterConfig["options"] as $filterConfigOption)
                    @if( $this->matchedFilterQuery( $filterConfigOption["name"] ))
                        @php($found = true)
                        <div class="cursor-pointer hover:bg-gray-100 px-3 py-1"
                             wire:click="setSearchableFieldValue('filter.{{ $filterKey }}', '{{ $filterConfigOption["id"] }}')">
                            {{ $filterConfigOption["name"] }}
                        </div>
                    @endif
                @endforeach

                @if( !$found)
                    <div class="cursor-pointer hover:bg-gray-100 px-3 py-1 text-danger">
                        <em>Keine Ergebnisse gefunden</em>
                    </div>
                @endif
            </div>
        @else

            <select class="form-select" id="filter-{{ $filterKey }}"
                    wire:model="filter.{{ $filterKey }}">
                @foreach($filterConfig["options"] as $filterConfigOption)
                    <option value="{{ $filterConfigOption["id"] }}">{{ $filterConfigOption["name"] }}</option>
                @endforeach
            </select>

            @if( $filter[$filterKey] != $filterConfig["default"])
                <button class="btn border position-relative" type="button" style="z-index: 15 !important;"
                        wire:click="$set('filter.{{ $filterKey }}','{{ $filterConfig["default"] }}')">
                    <span>×</span>
                </button>
            @endif

            <div class="position-absolute top-0 right-0 left-0 bottom-0 z-10"
                 wire:click="openSearchableField('{{ $filterKey }}')">

            </div>
        @endif
    </div>


</div>
