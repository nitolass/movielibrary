<!DOCTYPE html>
<html>
<head>
    <title>Informe de Usuario</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; padding: 20px; }

        /* Cabecera */
        .header { border-bottom: 2px solid #eab308; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #000; }
        .logo span { color: #eab308; }
        .meta { float: right; text-align: right; font-size: 12px; color: #666; }

        /* Sección Datos */
        .section-title { font-size: 16px; font-weight: bold; border-left: 4px solid #eab308; padding-left: 10px; margin: 20px 0; color: #444; }

        .info-grid { width: 100%; margin-bottom: 30px; }
        .info-grid td { padding: 8px; vertical-align: top; }
        .label { font-weight: bold; color: #666; font-size: 12px; text-transform: uppercase; }
        .value { font-size: 14px; color: #000; }

        /* Tabla de Actividad */
        .activity-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .activity-table th { background: #333; color: #fff; padding: 8px; text-align: left; }
        .activity-table td { border-bottom: 1px solid #eee; padding: 8px; }

        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

<div class="header">
    <div class="meta">
        ID Informe: #USR-{{ $user->id }}-{{ date('Y') }}<br>
        Fecha: {{ date('d/m/Y H:i') }}
    </div>
    <div class="logo">Movie<span>Hub</span> Admin</div>
</div>

<div class="section-title">Datos del Usuario</div>

<table class="info-grid">
    <tr>
        <td width="50%">
            <div class="label">Nombre Completo</div>
            <div class="value">{{ $user->name }} {{ $user->surname }}</div>
        </td>
        <td width="50%">
            <div class="label">Correo Electrónico</div>
            <div class="value">{{ $user->email }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Estado de cuenta</div>
            <div class="value" style="color: green;">Activo</div>
        </td>
        <td>
            <div class="label">Miembro desde</div>
            <div class="value">{{ $user->created_at->isoFormat('LL') }}</div>
        </td>
    </tr>
</table>

<div class="section-title">Películas Pendientes (Watch Later)</div>

@if($user->watchLater->count() > 0)
    <table class="activity-table">
        <thead>
        <tr>
            <th>Película</th>
            <th>Año</th>
            <th>Director</th>
            <th>Agregada el</th>
        </tr>
        </thead>
        <tbody>
        {{-- AQUÍ ESTÁ EL BUCLE FOREACH --}}
        @foreach($user->watchLater as $movie)
            <tr>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->year }}</td>
                <td>{{ $movie->director->name ?? 'N/A' }}</td>
                <td>{{ optional($movie->pivot->created_at)->format('d/m/Y') ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p style="color: #666; font-style: italic; padding: 20px; background: #f9f9f9; border-radius: 5px;">
        Este usuario no tiene películas en su lista de pendientes actualmente.
    </p>
@endif

<div class="footer">
    Documento generado automáticamente por el sistema de administración de MovieHub.
</div>

</body>
</html>
