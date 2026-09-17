{{-- NGUOI 3: so do chon ghe - mau xanh trong, vang dang giu, do da dat --}}
<h1>Chon ghe</h1>
<div class="seat-map">
@foreach ($seats as $s)
    <span class="seat seat-{{ $s->status }}" data-id="{{ $s->id }}">{{ $s->seat->seat_code }}</span>
@endforeach
</div>
