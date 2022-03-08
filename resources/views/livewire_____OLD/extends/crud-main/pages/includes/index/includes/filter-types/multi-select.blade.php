<div class="pr-3">
    <label for="filter-{{ $filterKey }}" class="form-text pr-4">{{ $filterConfig["title"] }}</label>

    <div class="input-group">
        <select class="form-select" id="filter-{{ $filterKey }}"
                multiple
                wire:model="filter.{{ $filterKey }}">

            @foreach($filterConfig["options"] as $filterConfigOption)
                <option value="{{ $filterConfigOption["id"] }}">{{ $filterConfigOption["name"] }}</option>
            @endforeach
        </select>

        @if( $filter[$filterKey] != $filterConfig["default"])
            <button class="btn btn-outline-secondary" type="button"
                    wire:click="$set('filter.{{ $filterKey }}','{{ $filterConfig["default"] }}')">
                <span>×</span>
            </button>
        @endif
    </div>
</div>
