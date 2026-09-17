{{-- NGUOI 2: danh sach phim (User xem) --}}
<h1>Danh sach phim</h1>
@foreach ($movies as $movie)
    <div>{{ $movie->title }} - {{ $movie->genre }}</div>
@endforeach
{{ $movies->links() }}
