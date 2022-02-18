<div class="-footer d-flex">

    @includeFirst([
                    $childPath .".index.pagination",
                    $path. ".pages.includes.index.pagination"
                    ])

    <div class="ml-auto ">

        <div class="d-flex">


            @if( $allowLayoutChange )

                <div class="btn-group mr-3">
                    <button class="btn btn-outline-secondary {{ $indexLayout == "cards" ? "active" : "" }}"
                            title="Karten-Layout"
                            wire:click="$set('indexLayout', 'cards')">
                        <i class="bi bi-card-text"></i>
                    </button>
                    <button class="btn btn-outline-secondary {{ $indexLayout == "table" ? "active" : "" }}"
                            title="Tabellen-Layout"
                            wire:click="$set('indexLayout', 'table')">
                        <i class="bi bi-table"></i>
                    </button>
                </div>
            @endif

            <div>
                <div class="input-group">
            <span class="input-group-text">
                {{ $paginator["total"] }} {{ $paginator["total"] == 1 ? $wordings["name"] : $wordings["names"]  }}
            </span>

                    <select class="form-select" wire:model="perPage">
                        @foreach($perPageConfig as $item)
                            <option value="{{ $item["value"] }}">{{ $item["name"] }}</option>
                        @endforeach
                    </select>

                    <span class="input-group-text">pro Seite</span>
                </div>
            </div>
        </div>
    </div>
</div>
