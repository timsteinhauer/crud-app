<td class="-column {{--{!! $tableHead[$key]["css_classes"] ?? '' !!}--}}">
    @if( \View::exists($childPath .'.index.column.'.$key) )
        @include($childPath .'.index.column.'.$key)
    @else
        @if(is_array($column))
            <b style="color: red">Spalte {{ $key }} beinhaltet Array, String erwartet!</b>
        @else
            {!! $column !!}
        @endif
    @endif
</td>
