{{-- NGUOI 2: chi tiet phim + lich chieu --}}
<h1>{{ $movie->title }}</h1>
<p>{{ $movie->description }}</p>
@foreach ($movie->showtimes as $st)
    <a href="/booking/{{ $st->id }}/seats">{{ $st->room_name }} - {{ $st->start_time }}</a>
@endforeach
