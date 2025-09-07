<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="A Laravel application" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monoton&family=Noto+Sans+JP:wght@100..900&display=swap"
        rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- fullcalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
</head>

<body class="font-sans">
    @if (request()->routeIs('top.page'))
        @include('modules.top-header')
        <main>
            {{ $slot }}
        </main>
    @else
        @include('modules.app-header')
        <main>
            <div class="w-full h-20"></div>
            <div class="w-screen h-max flex">
                <div class="w-48 max-md:hidden"></div>
                <div class="w-3/4 h-auto my-10 mx-auto p-10 border border-filter rounded-xl shadow-custom">
                    {{ $slot }}
                </div>
            </div>
        </main>
    @endif

</body>

</html>
