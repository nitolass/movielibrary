@extends('pdf.layout')

@section('content')
    <div style="margin-bottom: 20px;">
        <h1>{{ __('Listado de Películas') }}</h1>
        <p>{{ __('Total de títulos en catálogo') }}: {{ $movies->count() }}</p>
    </div>

    <table class="data-table w-100">
        <thead>
        <tr>
            <th style="width: 50px;">ID</th>
            <th>{{ __('Título') }}</th>
            <th>{{ __('Año') }}</th>
            <th>{{ __('Director') }}</th>
            <th>{{ __('Géneros') }}</th>
            <th>{{ __('Duración') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->id }}</td>
                <td class="bold">{{ $movie->title }}</td>
                <td>{{ $movie->year }}</td>
                <td>{{ $movie->director->name ?? 'N/A' }}</td>
                <td>
                    {{ $movie->genres->pluck('name')->join(', ') }}
                </td>
                <td>{{ $movie->duration }} min</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
