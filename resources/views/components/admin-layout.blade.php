<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} -Admin </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!--Icons from fontawsome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Styles -->
        @livewireStyles

        <script>
            window.api_token = "{{ session('api_token') ?? '' }}";
        </script>
    </head>
    <body class="font-sans antialiased relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/admin-back.jpg') }}');">

            <x-admin-header />

            <div class="flex">
                <x-admin-sidebar />

                <div class="flex-1">
                    <!-- Header slot content -->
                    @if (isset($header))
                        <div class="pt-[15px] px-6">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Page content slot -->
                    <main class="px-6 py-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>


        @stack('modals')

        @livewireScripts

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    </body>
</html>
