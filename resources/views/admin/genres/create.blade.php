<form method="POST" action="{{ route('admin.genres.store') }}">
    @csrf
    <input name="name" placeholder="Nombre">
    <textarea name="description"></textarea>
    <button type="submit">Guardar</button>
</form>
