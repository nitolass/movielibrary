@extends('pdf.layout')

@section('content')
    {{-- CABECERA DE LA FICHA --}}
    <div style="border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 30px;">
        <h1 style="color: #e74c3c; font-size: 24px; margin-bottom: 5px;">{{ $movie->title }}</h1>
        <span style="background: #333; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
            {{ $movie->year }}
        </span>
        <span style="color: #666; margin-left: 10px;">{{ $movie->duration }} min</span>
    </div>

    {{-- DATOS TÉCNICOS --}}
    <table class="w-100" style="margin-bottom: 30px;">
        <tr>
            <td class="td-top w-50">
                <h3 style="border-bottom: 1px solid #e74c3c; display: inline-block; margin-bottom: 10px;">
                    {{ __('Sinopsis') }}
                </h3>
                <p style="text-align: justify; color: #555;">
                    {{ $movie->description }}
                </p>
            </td>
            <td class="td-top" style="padding-left: 20px;">
                <p><strong>{{ __('Director') }}:</strong> {{ $movie->director->name ?? 'N/A' }}</p>
                <p><strong>{{ __('Géneros') }}:</strong> {{ $movie->genres->pluck('name')->join(', ') }}</p>
                <p><strong>{{ __('Puntuación Media') }}:</strong> {{ number_format($movie->reviews->avg('rating'), 1) }} / 5</p>
                <p><strong>{{ __('Total Reseñas') }}:</strong> {{ $movie->reviews->count() }}</p>
            </td>
        </tr>
    </table>

    {{-- SECCIÓN REVIEWS (COMPLEJO) --}}
    <div style="margin-top: 40px;">
        <h2 style="background: #eee; padding: 10px; border-left: 5px solid #e74c3c;">
            {{ __('Reseñas de Usuarios') }}
        </h2>

        @if($movie->reviews->count() > 0)
            <table class="data-table w-100">
                <thead>
                <tr>
                    <th style="width: 20%;">{{ __('Usuario') }}</th>
                    <th style="width: 15%;">{{ __('Fecha') }}</th>
                    <th style="width: 10%;">{{ __('Nota') }}</th>
                    <th>{{ __('Comentario') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movie->reviews as $review)
                    <tr>
                        <td class="bold">{{ $review->user->name }}</td>
                        <td>{{ $review->created_at->format('d/m/Y') }}</td>
                        <td>
                                <span class="badge" style="background: {{ $review->rating >= 4 ? '#27ae60' : ($review->rating >= 3 ? '#f39c12' : '#c0392b') }};">
                                    {{ $review->rating }} ★
                                </span>
                        </td>
                        <td>{{ $review->content }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; font-style: italic; margin-top: 20px;">
                {{ __('No hay reseñas registradas para esta película.') }}
            </p>
        @endif
    </div>
@endsection
