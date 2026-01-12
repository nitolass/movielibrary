<form method="POST" action="{{ route('admin.genres.update', $genre) }}">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $genre->name }}">
    <textarea name="description">{{ $genre->description }}</textarea>
    <button type="submit">Actualizar</button>
</form>
