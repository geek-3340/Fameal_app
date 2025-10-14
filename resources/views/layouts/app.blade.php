<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Famealは親子献立カレンダーアプリです。離乳食期のお子様を持つご家庭の献立を効率的に管理できます。" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monoton&family=Noto+Sans+JP:wght@100..900&display=swap"
        rel="stylesheet">

    <!-- fullcalendar CDN -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/list.global.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/fullcalendar.css', 'resources/js/app.js'])

</head>

<body class="text-base font-sans text-text overflow-x-hidden">

    <main>
        @if (request()->routeIs('menus.month.index') ||
                request()->routeIs('menus.week.index') ||
                request()->routeIs('baby.menus.month.index') ||
                request()->routeIs('baby.menus.month.index') ||
                request()->routeIs('dishes.index') ||
                request()->routeIs('babyfoods.index') ||
                request()->routeIs('shopping.list.index'))
            @include('layouts.partials.contents-header')
            {{ $slot }}
        @else
            @include('layouts.partials.top-header')
            {{ $slot }}
        @endif
    </main>

</body>

</html>
