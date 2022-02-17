@extends('livewire.extends.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-edit-wrapper">

        <div class="-both-forms-wrapper">
            @includeIf($childPath .".forms.both-forms")
        </div>

        <div class="-edit-form">
            @includeIf($childPath .".forms.edit-form")
        </div>

    </div>
@endsection
