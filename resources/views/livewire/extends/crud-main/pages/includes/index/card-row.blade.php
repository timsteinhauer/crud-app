@if(is_array($column))
    <b style="color: red">Wert {{ $key }} beinhaltet Array, String erwartet!</b>
@else

    @if( $first )
        <h5 class="card-title">
            {!! $headColumn["display"] !!}: {!! $column !!}
        </h5>
    @else
        <div class="card-title">
            {!! $headColumn["display"] !!}: {!! $column !!}
        </div>
    @endif
@endif
