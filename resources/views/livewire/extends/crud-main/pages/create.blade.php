@extends('livewire.extends.crud-main.pages.extends.subpages-wrapper')

@section("crud-page")
    <div class="-create-wrapper">

        @foreach($this->forms() as $field)

            @if( !isset($field["hide_on_create"]) )
                @include("templates.form.". $field["type"], $field)
            @elseif( $field["hide_on_create"] == false)
                @include("templates.form.". $field["type"], $field)
            @endif

        @endforeach

    </div>
@endsection
