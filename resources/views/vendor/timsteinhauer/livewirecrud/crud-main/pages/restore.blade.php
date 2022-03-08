@extends('vendor.timsteinhauer.livewirecrud.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-restore-wrapper">

        <div class="alert {{ $styling["restore"]["message"] }}">
            {!! $this->insertName($wordings["restore"]["message"]) !!}
        </div>
    </div>
@endsection

