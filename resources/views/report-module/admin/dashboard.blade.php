{{-- NGUOI 5: dashboard tong quan Admin --}}
<h1>Dashboard</h1>
<h3>Top phim ban chay</h3>
@foreach ($topMovies as $m)
    <div>{{ $m->title }}: {{ $m->total_bookings }} ve</div>
@endforeach
