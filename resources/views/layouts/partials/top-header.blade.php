<header class="w-full">
    <div class=" w-11/12 h-20 flex justify-between items-center mx-auto border-b border-main max-md:h-16">
        <div class="pl-24 text-main flex items-end max-md:block max-md:pl-12">
            <h1 class="mr-4 font-monoton text-4xl leading-none max-md:text-2xl">Fameal</h1>
            <p class="max-md:text-sm">親子献立カレンダーアプリ</p>
        </div>
        <nav class="flex pr-4">
            @if (request()->routeIs('top.page'))
                @auth
                    <x-link-button href="{{ route('menus.index',['category' => 'dishes','viewType' => 'month']) }}" type="primary">
                        マイページ
                    </x-link-button>
                @else
                    <x-link-button href="{{ route('login') }}" type="primary">
                        ログイン
                    </x-link-button>
                @endauth
                <x-link-button href="{{ route('register') }}" type="register" class="ml-4 max-md:ml-2">
                    新規登録
                </x-link-button>
            @else
                <x-link-button href="{{ url()->previous() }}" type="primary">
                    戻る
                </x-link-button>
            @endif
        </nav>
    </div>
</header>
