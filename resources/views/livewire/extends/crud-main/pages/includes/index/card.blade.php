<div class="col">
    <div class="card">
        <div class="card-body">

            @php( $first = 1)
            @foreach($this->cardLayout() as $key => $headColumn)

                @if( isset($item[$key]))
                    @php( $column = $item[$key])

                    @if( \View::exists($childPath .'.index.card-row.'.$key) )
                        @if($first == 1)
                            @php( $first = 0)
                            <h5 class="card-title">
                                @include($childPath .'.index.card-row.'.$key)
                            </h5>
                        @else
                            @include($childPath .'.index.card-row.'.$key)
                        @endif
                    @else

                        @if($first == 1)
                            @php( $first = 0)

                            @if(is_array($column))
                                <b style="color: red">Wert {{ $key }} beinhaltet Array, String erwartet!</b>
                            @else
                                <h5 class="card-title">{!! $headColumn["display"] !!} {!! $column !!}</h5>
                            @endif
                        @else
                            @if(is_array($column))
                                <b style="color: red">Wert {{ $key }} beinhaltet Array, String erwartet!</b>
                            @else
                                <div class="card-text">{!! $headColumn["display"] !!} {!! $column !!}</div>
                            @endif
                        @endif

                    @endif
                @endif
            @endforeach
        </div>

        @if( $allowed["edit"] || $allowed["delete"] || $allowed["clone"] || $allowed["restore"] || $allowed["open"])

            @includeFirst([
                $childPath .".index.card-actions",
                $path. ".pages.includes.index.card-actions"
                ])

        @endif
    </div>
</div>
