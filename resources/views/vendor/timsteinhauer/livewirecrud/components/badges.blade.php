@foreach($items as $badge)
    <span class="badge bg-{{ $color ?? "primary" }} {{ $badge["class"] ?? "mr-1" }}" {{ $badge["style"] ?? "" }}>
        {{ $badge["name"] }}
    </span>
@endforeach
