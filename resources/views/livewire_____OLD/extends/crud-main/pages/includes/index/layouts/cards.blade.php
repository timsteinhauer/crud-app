@if(count($items) > 0)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-3">
        @foreach ($items as $index => $item)

            @includeFirst([
                $childPath .".index.card",
                $path. ".pages.includes.index.card"
                ])

        @endforeach
    </div>
@else
    <div class="alert bg-primary">
        {{ $wordings["no_items"] ?? "Keine Daten gefunden." }}
    </div>
@endif
