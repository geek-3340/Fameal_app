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
</head>

<body class="font-sans text-text">
    <header class="w-11/12 h-20 mx-auto border-b border-filter">
        <div class=" h-full flex justify-between items-center">
            <div class=" flex items-end">
                <h1 class=" ml-28 mr-3 font-monoton text-main text-4xl leading-none">Fameal</h1>
                <p class="text-main text-base leading-6">親子献立カレンダーアプリ</p>
            </div>
        </div>
    </header>
    <main class=" w-full flex justify-center">
        @if (request()->routeIs('profile.edit'))
            <div class="w-full max-w-md mt-8 px-6 py-4 bg-white border border-filter rounded-xl">
                {{ $slot }}
            </div>
        @else
            <div class="w-full max-w-xs mt-8 px-6 py-4 bg-white border border-filter rounded-xl">
                {{ $slot }}
            </div>
        @endif

    </main>
</body>

</html>
