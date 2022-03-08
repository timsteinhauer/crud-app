<div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <button class="btn btn-sm btn-secondary mr-3" wire:click="openIndex()">
                <i class="bi bi-arrow-left-short"></i>
            </button>
            <h5 class="card-title mb-0">{{ $wordings["names"] }} {{ $wordings[$currentPage]["headline"] }}</h5>
        </div>
        <div class="card-body">
            @yield('crud-page')
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-sm btn-secondary" wire:click="openIndex()">
                {{ $wordings["back_btn"] }}
            </button>

            <button class="btn btn-sm {{ $styling[$currentPage]["submit_btn"] }} ml-3"
                    wire:click="{{ $formActions[$currentPage]["submit_btn"] }}()">
                {{ $wordings[$currentPage]["submit_btn"] }}
            </button>
        </div>
    </div>


</div>
