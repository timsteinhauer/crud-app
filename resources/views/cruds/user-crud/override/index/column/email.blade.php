<div class="d-flex w-100">

    <div>{{ $column["email"] }}</div>

    <div class="ml-auto">
        @if($column["verified_at"] == null)
            <span class="badge bg-danger">nicht verifiziert</span>
        @else
            <span class="badge bg-success">verifiziert</span>
        @endif
    </div>
</div>
