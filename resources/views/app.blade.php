<!DOCTYPE html>
<html>
  <head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="publisher" content="PT. Botika Teknologi Indonesia">
    <meta name="author" content="Botika Tech Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <!-- Title -->
    <title inertia>Best Place to Shop - {{ config('app.name') }}</title>
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Route --}}
    @routes
    {{-- Inertia --}}
    @inertiaHead
  </head>
  <body>
    <!-- Browser does not support JavaScript! -->
    <noscript>
        We're sorry but {{ config('app.name') }} doesn't work properly without JavaScript enabled. Please enable it to continue.
    </noscript>
    <!-- Inertia.js -->
    @inertia
  </body>
</html>