{{-- NGUOI 5: layout dung chung cho toan bo trang Admin --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Quan ly rap chieu phim</title>
</head>
<body>
    <nav>
        <a href="{{ route("admin.dashboard") }}">Dashboard</a>
        <a href="{{ route("admin.movies.index") }}">Quan ly phim</a>
        <a href="{{ route("admin.reports.revenue") }}">Bao cao doanh thu</a>
    </nav>
    <main>@yield("content")</main>
</body>
</html>
