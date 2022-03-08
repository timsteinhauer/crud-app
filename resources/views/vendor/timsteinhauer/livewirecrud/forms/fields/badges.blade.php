<div class="input-group mb-3 {{ $config["class"] ?? "" }}" style="{{ $config["style"] ?? "" }}">

    <span class="input-group-text">{{ $title }}</span>

    <div class="d-flex border align-items-center flex-1 @error($keyPath) is-invalid @enderror">
        @foreach($config["options"] as $option)

            @if( isset($form[$key][$option["id"]]) && $form[$key][$option["id"]] )
                <span class="badge ml-2 cursor-pointer bg-primary"
                      wire:click="unsetArrayAt('{{$keyPath}}.{{ $option["id"] }}')">
                    {!! $option["name"] !!}
                </span>
            @else
                <span class="badge ml-2 cursor-pointer bg-secondary"
                      wire:click="$set('{{$keyPath}}.{{ $option["id"] }}', '1')">
                  {!! $option["name"] !!}
                </span>
            @endif
        @endforeach
    </div>

    @error($keyPath)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
