<div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <button class="btn btn-sm btn-secondary mr-3" wire:click="openIndex()">
                <i class="bi bi-arrow-left-short"></i>
            </button>
            <h5 class="card-title mb-0">Benutzer anlegen</h5>
        </div>
        <div class="card-body">
            @yield('crud-page')
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-sm btn-secondary">Zurück</button>
            <button class="btn btn-sm btn-primary">Erstellen</button>
        </div>
    </div>


</div>
