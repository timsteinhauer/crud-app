@extends('vendor.timsteinhauer.livewirecrud.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-final-delete-wrapper">

        <div class="alert {{ $styling["delete"]["message"] }}">
            {!! $this->insertName($wordings["delete"]["message"]) !!}
        </div>
    </div>
@endsection

