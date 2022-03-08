<div class="-footer d-flex">

    @includeFirst([
                    $childPath .".index.pagination",
                    $path. ".pages.includes.index.pagination"
                    ])

    <div class="ml-auto ">

        <div class="d-flex">


            @if( $indexLayout == "cards" )
                <div class="mr-3">
                    <div class="input-group">
                    <span class="input-group-text">
                        Sortieren
                    </span>

                        <select class="form-select" wire:model="sortField">
                            @foreach($this->tableColumns() as $columnKey => $column)
                                @if( isset($column["sorting"]) && $column["sorting"] === true )
                                <option value="{{ $columnKey }}">{{ $column["display"] }}</option>
                                @endif
                            @endforeach
                        </select>

                        <button class="btn btn-outline-secondary" wire:click="sortBy('{{ $sortField }}')">
                            <i class="bi bi-sort-alpha-down{{ $sortAsc ? "" : "-alt" }}"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if( $allowLayoutChange )

                <div class="btn-group mr-3">
                    <button
                        class="btn {{ $indexLayout == "cards" ? "btn-outline-primary active" : "btn-outline-secondary" }}"
                        title="Karten-Layout"
                        wire:click="$set('indexLayout', 'cards')">
                        <i class="bi bi-card-text"></i>
                    </button>
                    <button
                        class="btn {{ $indexLayout == "table" ? "btn-outline-primary active" : "btn-outline-secondary" }}"
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
