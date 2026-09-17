{{-- NGUOI 5: bao cao doanh thu theo khoang ngay --}}
<h1>Doanh thu tu {{ $from }} den {{ $to }}</h1>
<table>
    <tr><th>Ngay</th><th>Doanh thu</th></tr>
    @foreach ($revenue as $r)
        <tr><td>{{ $r->date }}</td><td>{{ number_format($r->total) }}đ</td></tr>
    @endforeach
</table>
