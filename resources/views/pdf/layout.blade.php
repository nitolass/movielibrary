<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movie Library Export</title>
    <style>
        /* Estilos Generales */
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }

        /* Layout de Página */
        @page { margin: 100px 40px; }
        header { position: fixed; top: -80px; left: 0; right: 0; height: 60px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; }
        footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 40px; font-size: 10px; text-align: center; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }

        /* Utilidades para Tablas (Reemplazo de Flexbox) */
        .w-100 { width: 100%; }
        .w-50 { width: 50%; }
        table { width: 100%; border-collapse: collapse; }
        .td-top { vertical-align: top; }

        /* Estilos visuales */
        h1, h2 { color: #2c3e50; margin: 0; }
        .badge { background: #e74c3c; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        /* Tablas de datos */
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f8f9fa; }
    </style>
</head>
<body>
<header>
    <table class="w-100">
        <tr>
            <td style="font-size: 20px; font-weight: bold; color: #e74c3c;">
                🎬 MyMovieLibrary
            </td>
            <td class="text-right">
                Usuario: {{ auth()->user()->name ?? 'Invitado' }}
            </td>
        </tr>
    </table>
</header>

<footer>
    Generado automáticamente el {{ date('d/m/Y H:i') }}
</footer>

<main>
    @yield('content')
</main>
</body>
</html>
