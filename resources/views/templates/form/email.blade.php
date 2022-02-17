<div class="input-group mb-3 {{ $options["class"] ?? "" }}" style="{{ $options["style"] ?? "" }}">

    <span class="input-group-text">{{ $title }}</span>

    <input type="email"
           class="form-control @error($key) is-invalid @enderror"
           wire:model.debounce.500ms="{{ $key }}"
           {{ isset($options["required"]) && $options["required"] ? "required" : "" }}
           {{ isset($options["disabled"]) && $options["disabled"] ? "disabled" : "" }}
           placeholder="{{ $options["placeholder"] ?? "" }}">

    @error($key)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
