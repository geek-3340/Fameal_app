<header class=" fixed top-0 left-1/2 -translate-x-1/2 w-11/12 h-20 border-b border-filter">
    <div class=" h-full flex justify-between items-center">
        <div class=" flex items-end">
            <h1 class=" ml-28 mr-3 font-monoton text-main text-4xl leading-none">Fameal</h1>
            <p class="text-main text-base leading-6">親子献立カレンダーアプリ</p>
        </div>
        <nav class=" flex mr-5">
            @auth
                <a href="{{ route('contents') }}"
                    class="flex items-center justify-center mx-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                    マイページ
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center mx-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                    ログイン
                </a>
            @endauth
        </nav>
    </div>
</header>
