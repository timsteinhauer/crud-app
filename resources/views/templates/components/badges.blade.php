@foreach($items as $badge)
    <span class="badge bg-{{ $color ?? "primary" }} {{ $badge["class"] ?? "" }}" {{ $badge["style"] ?? "" }}>
        {{ $badge["name"] }}
    </span>
@endforeach
