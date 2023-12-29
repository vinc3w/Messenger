<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/favicon-16x16.png') }}">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css'])

    </head>
    <body class="font-sans antialiased h-screen flex flex-col justify-center items-center">

		<div class="text-9xl font-bold font-mono tracking-tight">Oops!</div>
		<div class="mt-3 font-semibold text-lg">404 Error - Page not found</div>
		<div class="mt-1">The page you are looking for either does not exist or has been taken down. Sorry for the inconveinence caused.</div>
		<a href="/app" class="mt-3">
			<x-primary-button class="px-5 py-3">Go to homepage</x-primary-button>
		</a>

    </body>
</html>
