{{-- NGUOI 3: lich su dat ve --}}
<h1>Lich su dat ve</h1>
@foreach ($bookings as $b)
    <div>Ma ve: {{ $b->ticket_code }} - {{ $b->total_price }}đ - {{ $b->status }}</div>
@endforeach
