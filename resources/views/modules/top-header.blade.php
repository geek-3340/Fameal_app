<header class="w-11/12 h-20 mx-auto bg-bg border-b border-filter">
    <div class=" h-full flex justify-between items-center">
        <div class="flex items-end max-md:block">
            <h1 class="ml-28 mr-3 font-monoton text-main text-4xl leading-none max-md:text-3xl">Fameal</h1>
            <p class="text-main text-base leading-6 max-md:ml-28 max-md:text-sm">親子献立カレンダーアプリ</p>
        </div>
        <nav class=" flex mr-5">
            @auth
                <a href="{{ route('menus.month.index') }}"
                    class="flex items-center justify-center mx-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                    マイページ
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="btn">
                    ログイン
                </a>
            @endauth
        </nav>
    </div>
</header>
