<h1>Géneros</h1>

<a href="{{ route('admin.genres.create') }}">Crear género</a>

@foreach ($genres as $genre)
    <p>{{ $genre->name }}</p>
@endforeach
