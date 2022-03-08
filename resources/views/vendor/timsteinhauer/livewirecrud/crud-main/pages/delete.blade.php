@extends('vendor.timsteinhauer.livewirecrud.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-delete-wrapper">

        @if( $useSoftDeleting )

            <div class="alert {{ $styling["soft_delete"]["message"] }}">
                {!! $this->insertName($wordings["soft_delete"]["message"]) !!}
            </div>

        @else

            <div class="alert {{ $styling["delete"]["message"] }}">
                {!! $this->insertName($wordings["delete"]["message"]) !!}
            </div>
        @endif
    </div>
@endsection
