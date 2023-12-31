<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/favicon-16x16.png') }}">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen py-6 font-sans text-gray-900 flex justify-center items-center antialiased">
        <div class="w-full mx-5 flex flex-wrap-reverse max-w-3xl bg-white shadow-md overflow-hidden rounded-lg">
            <div class="w-full sm:w-[55%] sm:p-8 p-5">
                <div class="text-3xl mb-8">{{ $title }}</div>
                <div class="sm:border sm:border-gray-300 rounded-lg sm:p-8">
                    {{ $slot }}
                </div>
            </div>
            <div style="background-image: url({{ Vite::asset('resources/images/chat-bubble-bg.jpg') }})" class="h-[100px] sm:h-auto sm:min-h-full sm:w-[45%] w-full bg-cover bg-center bg-no-repeat"></div>
        </div>  
    </body>
</html>
