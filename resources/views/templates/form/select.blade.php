<div class="input-group mb-3 {{ $config["class"] ?? "" }}" style="{{ $config["style"] ?? "" }}">

    <span class="input-group-text">{{ $title }}</span>

    <select class="form-select"
            class="form-control @error($key) is-invalid @enderror"
            wire:model.debounce.500ms="{{ $key }}"
            {{ isset($config["required"]) && $config["required"] ? "required" : "" }}
            {{ isset($config["disabled"]) && $config["disabled"] ? "disabled" : "" }}
    >
        @foreach($config["options"] as $option)
            <option value="{{ $option["id"] }}">{!! $option["name"] !!}</option>
        @endforeach
    </select>

    @error($key)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
