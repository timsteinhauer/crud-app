<div class="d-flex -header mb-4">

    @if( $allowed["create"] )
        <div class="-new-btn pr-3">
            <label for="filter-create"
                   class="form-text">&nbsp;{{-- only placeholder for correct top spacing --}}</label>
            <div>
                <button wire:click="openCreateForm()" type="button" class="btn btn-primary whitespace-nowrap">
                    {!! $wordings["new"] ?? '<i class="bi bi-plus-lg"></i>'!!}
                </button>
            </div>
        </div>
    @endif

    @if( $allowed["show_search"] )
        <div class="-search pr-3">
            <label for="filter-search"
                   class="form-text">&nbsp;{{-- only placeholder for correct top spacing --}}</label>
            <div class="input-group">
                <input class="form-control" wire:model.debounce.500ms="search" style="padding-right: 0;"
                       placeholder="{{ $wordings["search"] ?? 'Suchen...'}}" type="search">

                <button class="btn border" type="button" wire:click="$set('search', '')">
                    <span>×</span>
                </button>
            </div>

        </div>
    @endif

    @if( $allowed["show_filter"] )

        <div class="-filter ml-lg-auto d-flex">
            @includeFirst([
                    $childPath .".index.filter",
                    $path. ".pages.includes.index.filter"
                    ])

        </div>
    @endif


</div>
