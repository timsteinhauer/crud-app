<td class="text-right">

    @yield('row-actions-'.$model)

    @if( $viewOnlyMode === false)

        {{--@if( $useSoftDeleting )
            @if( $row->deleted_at === null )
                <button title="{{ $texts["edit"] }}" type="button" class="btn btn-sm btn-primary"
                        wire:click="editFormToggle({{ $row->id }})">
                    <i class="btn-icon cil-cog"></i>
                </button>

                <button title="{{ $texts["delete"] }}" type="button" class="btn btn-sm btn-danger"
                        wire:click="deleteFormToggle({{ $row->id }})">
                    <i class="btn-icon cil-trash"></i>
                </button>
            @else

                <button title="{{ $texts["restore"] }}" type="button" class="btn btn-sm btn-warning"
                        wire:click="restoreFormToggle({{ $row->id }})">
                    <i class="btn-icon cil-reload"></i>
                </button>
            @endif
        @else
            <button title="{{ $texts["edit"] }}" type="button" class="btn btn-sm btn-primary"
                    wire:click="editFormToggle({{ $row->id }})">
                <i class="btn-icon cil-cog"></i>
            </button>

            <button title="{{ $texts["delete"] }}" type="button" class="btn btn-sm btn-danger"
                    wire:click="deleteFormToggle({{ $row->id }})">
                <i class="btn-icon cil-trash"></i>
            </button>
        @endif--}}
    @endif
</td>
