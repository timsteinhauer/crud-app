{{ $column["email"] }}

@if($column["verified_at"] == null)
    <span class="badge bg-danger">nicht verifiziert</span>
@else
    <span class="badge bg-success">verifiziert</span>
@endif
