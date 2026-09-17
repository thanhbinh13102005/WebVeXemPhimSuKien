{{-- NGUOI 2: form them/sua phim --}}
<form method="POST" action="{{ route("admin.movies.store") }}">
    @csrf
    <input type="text" name="title" placeholder="Ten phim">
    <input type="number" name="duration_minutes" placeholder="Thoi luong (phut)">
    <input type="text" name="genre" placeholder="The loai">
    <input type="text" name="age_rating" placeholder="Do tuoi (P/C13/C16/C18)">
    <select name="status">
        <option value="coming_soon">Sap chieu</option>
        <option value="now_showing">Dang chieu</option>
    </select>
    <button type="submit">Luu</button>
</form>
