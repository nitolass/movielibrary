<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MovieHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-['Outfit'] text-gray-100 antialiased h-screen overflow-hidden bg-[#0f1115]">

<div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
    <div class="absolute -top-[40%] -left-[20%] w-[80%] h-[80%] rounded-full bg-yellow-500/5 blur-[150px] mix-blend-screen"></div>
    <div class="absolute -bottom-[40%] -right-[20%] w-[80%] h-[80%] rounded-full bg-indigo-900/10 blur-[150px] mix-blend-screen"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_0%,_rgba(15,17,21,0.8)_100%)]"></div>
</div>

<div class="min-h-screen flex flex-col justify-center items-center p-4 relative z-10">
    {{ $slot }}
</div>

</body>
</html>
