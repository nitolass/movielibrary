<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MovieHub') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fondo oscuro de toda la página */
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
        }

        .background-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(40%);
        }

        /* Botón Movies más visible */
        .btn-movies {
            cursor: pointer;
            gap: 0.5rem;
            border: none;
            transition: all 0.3s ease-in-out;
            border-radius: 100px;
            font-weight: 800;
            padding: 0.85rem 1.5rem;
            font-size: 0.925rem;
            line-height: 1rem;
            background-color: rgba(0, 0, 0, 0.7); /* más oscuro para resaltar */
            box-shadow:
                0 4px 10px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.04),
                inset 0 0 0 1px rgba(255, 255, 255, 0.04);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-movies:hover {
            box-shadow:
                0 6px 14px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.08),
                inset 0 0 0 1px rgba(252, 232, 3, 0.08);
            color: #fce803;
            transform: translateY(-0.25rem);
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* MovieHub siempre animado (igual que hover) */
        .logo-title {
            font-size: 3rem;
            font-weight: 900;
            color: #fce803; /* amarillo */
            transform: scale(1.1) rotate(-2deg); /* igual que el hover */
            display: inline-block;
        }

        /* Botón azul de inicio de sesión con SVG */
        .user-profile {
            cursor: pointer;
            transition: 0.3s ease;
            background: linear-gradient(
                to bottom right,
                #fdcb00 0%,
                rgba(46, 142, 255, 0) 30%
            );
            background-color: rgb(131, 108, 12);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            padding: 2px;
            text-decoration: none;
        }

        .user-profile:hover,
        .user-profile:focus {
            background-color: rgb(253, 203, 0);
            box-shadow: 0 0 10px rgba(136, 119, 1, 0.98);
            outline: none;
        }

        .user-profile-inner {
            height: 47px;
            border-radius: 13px;
            background-color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #fff;
            font-weight: 600;
            white-space: nowrap;
            padding: 0 12px;
        }

        .user-profile-inner svg {
            width: 27px;
            height: 27px;
            fill: #fff;
        }

        /* Botón morado de registro sin SVG */
        .user-profile-purple {
            cursor: pointer;
            transition: 0.3s ease;
            background: linear-gradient(
                to bottom right,
                #f2f2f6 0%,
                rgba(168, 85, 247, 0) 30%
            );
            background-color: rgba(251, 249, 251, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            padding: 2px;
            text-decoration: none;
        }

        .user-profile-purple:hover,
        .user-profile-purple:focus {
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .user-profile-purple-inner {
            height: 47px;
            border-radius: 13px;
            background-color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            white-space: nowrap;
            padding: 0 12px;
        }
        /* Botón rojo elegante (Cerrar sesión) */
        .logout-button {
            cursor: pointer;
            transition: 0.3s ease;
            background: linear-gradient(
                to bottom right,
                #ff3b3b 0%,
                rgba(255, 59, 59, 0) 30%
            );
            background-color: rgba(255, 59, 59, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            padding: 2px;
            text-decoration: none;
            border: none;
        }

        .logout-button:hover,
        .logout-button:focus {
            background-color: rgba(255, 59, 59, 0.7);
            box-shadow: 0 0 10px rgba(255, 59, 59, 0.5);
            outline: none;
        }

        .logout-button-inner {
            height: 47px;
            border-radius: 13px;
            background-color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            white-space: nowrap;
            padding: 0 16px;
        }

    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">

<!-- Fondo de imagen oscuro -->
<div class="background-image">
    <img src="{{ asset('images/muchaspeliculas.jpg') }}" alt="Fondo">
</div>

<!-- Header -->
<header class="flex justify-between items-center px-8 py-4 bg-transparent">
    <div class="logo-title">
        {{ config('app.name', 'MovieHub') }}
    </div>

    <div class="space-x-4 flex items-center">
        @guest
            <a href="{{ route('login') }}" class="user-profile">
                <div class="user-profile-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Iniciar Sesión
                </div>
            </a>

            <a href="{{ route('register') }}" class="user-profile-purple">
                <div class="user-profile-purple-inner">
                    Registrarse
                </div>
            </a>
        @else
            <span class="px-4 py-2">Hola, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="logout-button">
                    <div class="logout-button-inner">
                        Cerrar sesión
                    </div>
                </button>
            </form>
        @endguest
    </div>
</header>

<!-- Contenido central -->
<main class="flex-1 flex flex-col justify-center items-center text-center px-4">

    <h1 class="text-5xl font-bold mb-4">Bienvenido a {{ config('app.name') }}</h1>
    <p class="text-lg max-w-2xl mb-6">
        Explora tu catálogo de películas favorito.
        Consulta reseñas, descubre nuevos géneros y guarda tus favoritos.
    </p>

    <!-- Botón Movies centrado -->
    <div class="flex justify-center items-center mt-6">
         <a href="" class=""/> <!-- Aqui meteremos la ruta para que te lleve a la vista de peliculas -->
        <button class="btn-movies">Ver Películas</button>
    </div>

</main>

<!-- Footer opcional -->
<footer class="text-gray-400 text-sm py-4 text-center bg-transparent">
    &copy; {{ date('Y') }} {{ config('app.name', 'MovieHub') }}. Todos los derechos reservados.
</footer>

</body>
</html>
