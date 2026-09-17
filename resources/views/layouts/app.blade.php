{{-- NGUOI 5: layout dung chung cho toan bo trang User --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dat ve xem phim</title>
</head>
<body>
    <header>
        <a href="/">Trang chu</a>
        <a href="{{ route("movies.index") }}">Phim</a>
        @auth
            <a href="{{ route("booking.history") }}">Lich su ve</a>
        @else
            <a href="{{ route("login") }}">Dang nhap</a>
        @endauth
    </header>
    <main>@yield("content")</main>
</body>
</html>
