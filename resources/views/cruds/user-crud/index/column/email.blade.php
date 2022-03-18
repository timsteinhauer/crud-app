<div class="d-flex w-100">

    <div>{{ $column["email"] }}</div>

    <div class="ml-auto">
        @if($column["verified_at"] == null)
            <span class="badge border border-danger text-danger">nicht verifiziert</span>
        @else
            <span class="badge border border-success text-success">verifiziert</span>
        @endif
    </div>
</div>
