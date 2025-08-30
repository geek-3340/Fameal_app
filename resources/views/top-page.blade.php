<x-app-layout>
    <x-slot name="header">
        <div class=" h-full flex justify-between items-center">
            <div class=" flex items-end">
                <h1 class=" ml-5 mr-3 font-monoton text-main text-4xl leading-none">Fameal</h1>
                <p class="text-main text-base leading-6">親子献立カレンダーアプリ</p>
            </div>
            <nav class=" flex mr-5">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center justify-center mx-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                        マイページ
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center mx-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center ml-2 w-28 h-10 text-sm bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                        新規登録
                    </a>
                @endauth
            </nav>
        </div>
    </x-slot>
</x-app-layout>
</body>

</html>
