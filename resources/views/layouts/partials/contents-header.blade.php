<header x-data="{ openNavMenu: false, openAccountMenu: false }"
    class="fixed z-50 top-0 left-0 w-full h-20 flex justify-center items-center bg-white border-b border-main">
    <div class="w-11/12 pl-28 flex items-end text-main max-md:block max-md:pl-0 max-md:text-center">
        <h1 class="mr-4 font-monoton text-4xl leading-none max-md:text-3xl">Fameal</h1>
        <p class="max-md:text-sm">親子献立カレンダーアプリ</p>
    </div>
    @include('layouts.partials.components.hum-button')
    @include('layouts.partials.components.account-button')
    @include('layouts.partials.components.nav-menu')
    @include('layouts.partials.components.account-menu')
</header>
