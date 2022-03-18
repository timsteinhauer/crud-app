<div class="-view-page -model-{{ $model }} -page-{{ $currentPage }}">

    <div class="modal fade show {{ $styling["modal_class"] }}"
         style="display: block; {{ $styling["modal_style"] }}">
        <div class="modal-dialog {{ $styling["modal_dialog_class"] }}" style="{{ $styling["modal_dialog_style"] }}">
            <div class="modal-content {{ $styling["modal_content_class"] }}"
                 style="{{ $styling["modal_content_style"] }}">

                {!! $styling["modal_body_start"] !!}

                @include($path. ".pages.". $currentPage)

                {!! $styling["modal_body_end"] !!}
            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show"></div>
</div>


