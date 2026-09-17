{{-- NGUOI 1: form dang nhap --}}
<h2>Dang nhap</h2>
<form method="POST" action="{{ route("login") }}">
    @csrf
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mat khau">
    <button type="submit">Dang nhap</button>
</form>
