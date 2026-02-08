@extends('pdf.layout')

@section('content')
    {{-- TÍTULO DEL REPORTE --}}
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 28px; color: #e74c3c; margin-bottom: 5px; text-transform: uppercase;">{{ __('Informe de Estado') }}</h1>
        <p style="color: #666; margin: 0;">{{ __('Resumen de actividad y catálogo de MovieHub') }}</p>
        <p style="font-size: 12px; color: #999; margin-top: 5px;">{{ __('Fecha de emisión') }}: {{ date('d/m/Y H:i') }}</p>
    </div>

    {{-- 1. RESUMEN EJECUTIVO (KPIs) --}}
    <table class="w-100" style="margin-bottom: 40px; border: 1px solid #eee; background: #fdfdfd;">
        <tr>
            <td style="padding: 15px; text-align: center; border-right: 1px solid #eee;">
                <h2 style="font-size: 32px; color: #2c3e50; margin: 0;">{{ $stats['movies_count'] }}</h2>
                <span style="font-size: 10px; text-transform: uppercase; color: #7f8c8d;">{{ __('Películas') }}</span>
            </td>
            <td style="padding: 15px; text-align: center; border-right: 1px solid #eee;">
                <h2 style="font-size: 32px; color: #2c3e50; margin: 0;">{{ $stats['users_count'] }}</h2>
                <span style="font-size: 10px; text-transform: uppercase; color: #7f8c8d;">{{ __('Usuarios') }}</span>
            </td>
            <td style="padding: 15px; text-align: center; border-right: 1px solid #eee;">
                <h2 style="font-size: 32px; color: #2c3e50; margin: 0;">{{ $stats['total_reviews'] }}</h2>
                <span style="font-size: 10px; text-transform: uppercase; color: #7f8c8d;">{{ __('Reseñas') }}</span>
            </td>
            <td style="padding: 15px; text-align: center;">
                <h2 style="font-size: 32px; color: #e74c3c; margin: 0;">{{ number_format($stats['avg_score'], 1) }}</h2>
                <span style="font-size: 10px; text-transform: uppercase; color: #7f8c8d;">{{ __('Nota Media') }}</span>
            </td>
        </tr>
    </table>

    {{-- 2. TABLAS COMPARATIVAS (Dos columnas) --}}
    <table class="w-100" style="margin-bottom: 30px;">
        <tr>
            {{-- TOP MEJOR VALORADAS --}}
            <td class="w-50 td-top" style="padding-right: 15px;">
                <h3 style="border-bottom: 2px solid #f1c40f; padding-bottom: 5px; color: #444; font-size: 14px; text-transform: uppercase;">
                    ⭐ {{ __('Top 5 Mejor Valoradas') }}
                </h3>
                <table class="data-table w-100" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th>{{ __('Película') }}</th>
                        <th style="width: 40px; text-align: center;">{{ __('Nota') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topRated as $movie)
                        <tr>
                            <td>{{ $movie->title }}</td>
                            <td style="text-align: center; font-weight: bold;">{{ $movie->score }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>

            {{-- TOP MÁS POPULARES --}}
            <td class="w-50 td-top" style="padding-left: 15px;">
                <h3 style="border-bottom: 2px solid #3498db; padding-bottom: 5px; color: #444; font-size: 14px; text-transform: uppercase;">
                    🔥 {{ __('Top 5 Más Populares') }}
                </h3>
                <table class="data-table w-100" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th>{{ __('Película') }}</th>
                        <th style="width: 60px; text-align: center;">{{ __('Reviews') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mostReviewed as $movie)
                        <tr>
                            <td>{{ $movie->title }}</td>
                            <td style="text-align: center;">{{ $movie->reviews_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- 3. DISTRIBUCIÓN POR GÉNEROS (GRÁFICO VISUAL CSS) --}}
    <div style="margin-top: 20px; page-break-inside: avoid;">
        <h3 style="background: #2c3e50; color: white; padding: 8px 15px; font-size: 14px; margin-bottom: 15px;">
            📊 {{ __('Distribución del Catálogo por Género') }}
        </h3>

        <table class="w-100" style="font-size: 12px; border-collapse: separate; border-spacing: 0 8px;">
            @foreach($genresDistribution as $genre)
                @php
                    // Calculamos porcentaje para el ancho de la barra (max 100%)
                    $max = $genresDistribution->first()->movies_count;
                    $percent = ($genre->movies_count / $max) * 100;
                    $color = match(true) {
                        $percent > 75 => '#e74c3c',
                        $percent > 50 => '#e67e22',
                        $percent > 25 => '#f1c40f',
                        default => '#3498db'
                    };
                @endphp
                <tr>
                    <td style="width: 20%; padding-right: 10px; text-align: right; font-weight: bold; color: #555;">
                        {{ $genre->name }}
                    </td>
                    <td style="width: 70%; vertical-align: middle;">
                        {{-- Barra de progreso --}}
                        <div style="background: #eee; height: 10px; width: 100%; border-radius: 5px; overflow: hidden;">
                            <div style="background: {{ $color }}; height: 100%; width: {{ $percent }}%;"></div>
                        </div>
                    </td>
                    <td style="width: 10%; padding-left: 10px; color: #7f8c8d;">
                        {{ $genre->movies_count }} {{ __('pelis') }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
