<button title="{{ $wordings["index"]["edit_btn"] }}" type="button" class="btn btn-sm btn-primary"
        wire:click="openEditForm({{ $index }})">
    <i class="bi bi-gear"></i>
</button>


<button title="{{ $wordings["index"]["delete_btn"] }}" type="button" class="btn btn-sm {{ $styling["delete"]["submit_btn"] }}"
        wire:click="{{ $useInstantDeleting ? "submitInstantDeleteForm" : "openDeleteForm" }}({{ $index }})">
    <i class="bi bi-trash"></i>
</button>


{{-- @if( $viewOnlyMode === false)--}}

{{--@if( $useSoftDeleting )
    @if( $row->deleted_at === null )


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


@endif--}}