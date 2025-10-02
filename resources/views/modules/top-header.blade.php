<header class="w-11/12 h-20 mx-auto border-b border-main">
    <div class=" h-full flex justify-between items-center">
        <div class="flex items-end max-md:block">
            <h1 class="ml-28 mr-3 font-monoton text-main text-4xl leading-none max-md:text-3xl">Fameal</h1>
            <p class="text-main text-base leading-6 max-md:ml-28 max-md:text-sm">親子献立カレンダーアプリ</p>
        </div>
        <nav class=" flex mr-5">
            @auth
                <x-link-button href="{{ route('menus.month.index') }}" type="primary">
                    マイページ
                </x-link-button>
            @else
                <x-link-button href="{{ route('login') }}" type="primary">
                    ログイン
                </x-link-button>
            @endauth
            <x-link-button href="{{ route('register') }}" type="register" class="ml-2">
                新規登録
            </x-link-button>
        </nav>
    </div>
</header>
