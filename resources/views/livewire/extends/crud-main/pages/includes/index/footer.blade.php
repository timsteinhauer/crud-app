<div class="-footer d-flex">

    @includeFirst([
                    $childPath .".index.pagination",
                    $path. ".pages.includes.index.pagination"
                    ])

    <div class="ml-auto">
        <div class="input-group">
        <span class="input-group-text">
            {{ $paginator["total"] }} {{ $paginator["total"] == 1 ? $wordings["name"] : $wordings["names"]  }}
        </span>

            <select class="form-select" wire:model="perPage">
                @foreach($perPageConfig as $item)
                    <option value="{{ $item["value"] }}">{{ $item["name"] }}</option>
                @endforeach
            </select>

            <span class="input-group-text">
            pro Seite
        </span>
        </div>
    </div>
</div>
