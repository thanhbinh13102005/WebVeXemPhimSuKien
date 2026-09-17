{{-- NGUOI 1: form dang ky --}}
<h2>Dang ky</h2>
<form method="POST" action="{{ route("register") }}">
    @csrf
    <input type="text" name="name" placeholder="Ho ten">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mat khau">
    <input type="password" name="password_confirmation" placeholder="Nhap lai mat khau">
    <button type="submit">Dang ky</button>
</form>
