<div class="input-group  mb-3 {{ $config["class"] ?? "" }}" style="{{ $config["style"] ?? "" }}">

    <input type="checkbox"
           style="width: 30px"
           class=" align-self-center @error($keyPath) is-invalid @enderror"
           wire:model.debounce.500ms="{{ $keyPath }}"
           {{ isset($config["required"]) && $config["required"] ? "required" : "" }}
           {{ isset($config["disabled"]) && $config["disabled"] ? "disabled" : "" }}>

    <span class="input-group-text flex-grow-1">{{ $title }}</span>

    @error($keyPath)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
