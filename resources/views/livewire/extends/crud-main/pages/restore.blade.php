@extends('livewire.extends.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-restore-wrapper">

        <div class="alert {{ $styling["restore"]["message"] }}">
            {!! $this->parseAttr($wordings["restore"]["message"]) !!}
        </div>
    </div>
@endsection

