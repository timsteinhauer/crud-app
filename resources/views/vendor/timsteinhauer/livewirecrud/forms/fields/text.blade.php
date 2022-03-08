<div class="input-group mb-3 {{ $config["class"] ?? "" }}" style="{{ $config["style"] ?? "" }}">

    <span class="input-group-text">{{ $title }}</span>

    <input type="text"
           class="form-control @error($keyPath) is-invalid @enderror"
           wire:model.debounce.500ms="{{ $keyPath }}"
           {{ isset($config["required"]) && $config["required"] ? "required" : "" }}
           {{ isset($config["disabled"]) && $config["disabled"] ? "disabled" : "" }}
           placeholder="{{ $config["placeholder"] ?? "" }}">

    @error($keyPath)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
