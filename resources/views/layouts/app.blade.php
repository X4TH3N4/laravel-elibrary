<?php

use Illuminate\Support\Facades\Route?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ Route::currentRouteName() }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        <div>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <x-breadcrumb></x-breadcrumb>
            </div>
            <div class="-mt-12">
                {{ $slot }}
            </div>
        </div>

    </main>

    @include('layouts.footer')
</div>
</body>
<script src="https://www.unpkg.com/alpinejs@3.12.2/dist/cdn.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/datepicker.turbo.min.js"></script>
</html>
