<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Listado de Usuarios') }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        h1 { text-align: center; color: #444; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; color: #000; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; }
    </style>
</head>
<body>
<h1>{{ __('Listado Oficial de Usuarios') }}</h1>
<p>{{ __('Fecha de emisión') }}: {{ date('d/m/Y') }}</p>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>{{ __('Nombre') }}</th>
        <th>{{ __('Email') }}</th>
        <th>{{ __('Rol') }}</th>
        <th>{{ __('Fecha Registro') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }} {{ $user->surname }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge">{{ $user->role->name ?? 'User' }}</span>
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
