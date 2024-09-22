<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Page Heading -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ana Sayfa') }}
            </h2>
        </div>
    </header>
    <!-- Page Content -->
    <main>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="get" action="" class="flex items-center">
                            @csrf
                            @method('patch')

                            <div class="relative w-full">
                                <x-input-label for="book-search-bar" class="sr-only" :value="__('Ara')" />
                                <x-text-input id="book-search-bar" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />

                            </div>
                            <x-button class="ml-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="relative flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-blue-500 selection:text-white">

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="align-items-center content-center mx-auto justify-center">
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        {{ config('app.name') }} v{{ Illuminate\Foundation\Application::VERSION }} (PHP
                        v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </main>

    @stack('js')
    @include('layouts.footer')

</div>
</body>
</html>
