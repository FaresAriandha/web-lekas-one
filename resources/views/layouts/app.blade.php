<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/img/logo-lekas.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>{{ $title }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/flowbite.min.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>
    <div class="h-screen flex justify-start overflow-x-hidden no-scrollbar">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Content --}}
        <main class="w-screen sm:w-[calc(100%-16rem)] relative translate-x-0 sm:translate-x-64 duration-300"
            id="main">
            @include('components.header')
            <section class="w-full h-full overflow-y-auto p-6 bg-[#F3F4F6] no-scrollbar">
                @yield('content')
            </section>
            <footer class="sticky bottom-0 left-0 w-full flex justify-center items-center bg-[#344357] py-1">
                <h1 class="font-semibold text-white text-sm">
                    &copy; Copyright 2025 - PT. Lekas Kargo Sampai
                </h1>
            </footer>
        </main>

    </div>

    <div class="fixed h-screen w-screen bg-gray-300 opacity-0 z-10 top-0 left-0 hidden duration-500 transition-opacity"
        id="overlay">
    </div>

    @yield('modal-delete')


</body>

</html>
