@extends('livewire.extends.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-final-delete-wrapper">

        <div class="alert {{ $styling["delete"]["message"] }}">
            {!! $this->parseAttr($wordings["delete"]["message"]) !!}
        </div>
    </div>
@endsection

