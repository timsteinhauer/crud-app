<div class="input-group mb-3 {{ $options["class"] ?? "" }}" style="{{ $options["style"] ?? "" }}">
    <span class="input-group-text">{{ $title }}</span>
    <input type="email" class="form-control"
           wire:model="{{ $key }}"
           {{ isset($options["disabled"]) && $options["disabled"] ? "disabled" : "" }}
           placeholder="{{ $options["placeholder"] ?? "" }}">
</div>
