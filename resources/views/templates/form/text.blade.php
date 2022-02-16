<div class="input-group mb-3 {{ $options["class"] ?? "" }}" style="{{ $options["style"] ?? "" }}">
    <span class="input-group-text">{{ $title }}</span>
    <input type="text" class="form-control"
           wire:model="{{ $key }}"
           placeholder="{{ $options["placeholder"] ?? "" }}">
</div>
