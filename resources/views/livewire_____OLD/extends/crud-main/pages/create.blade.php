@extends('vendor.timsteinhauer.livewirecrud.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-create-wrapper">

        <div class="-both-forms-wrapper">
            @includeIf($childPath .".forms.both-forms")
        </div>

        <div class="-create-form">
            @includeIf($childPath .".forms.create-form")
        </div>

    </div>
@endsection
