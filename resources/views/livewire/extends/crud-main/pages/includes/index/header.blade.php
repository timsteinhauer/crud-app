<div class="d-flex -header mb-4">

    @if( $allowed["create"] )
        <div class="-new-btn pr-3">
            <button wire:click="openCreate" type="button" class="btn btn-primary whitespace-nowrap">
                {{ $wordings["new"] ?? 'Neu +'}}
            </button>
        </div>
    @endif

    @if( $allowed["show_search"] )
        <div class="-search pr-3">

            <div class="input-group">
                <input class="form-control" wire:model.debounce.500ms="search" style="padding-right: 0;"
                       placeholder="{{ $wordings["search"] ?? 'Suchen...'}}" type="search">

                <button class="btn btn-outline-secondary" type="button" wire:click="$set('search', '')">
                    <span>×</span>
                </button>
            </div>

        </div>
    @endif

    @if( $allowed["show_filter"] )

        <div class="-filter ml-lg-auto">
            @includeFirst([
                    $childPath .".index.filter",
                    $path. ".pages.includes.index.filter"
                    ])

        </div>
    @endif


</div>
