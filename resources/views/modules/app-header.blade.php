<header x-data="{ openLeft: false, openRight: false }" class="fixed top-0 left-0 w-screen h-20 border-b border-filter z-50">
    <div class="h-full flex justify-between items-center w-11/12 mx-auto">
        <div class="flex items-end">
            <h1 class="ml-28 mr-3 font-monoton text-main text-4xl leading-none">Fameal</h1>
            <p class="text-main text-base leading-6">親子献立カレンダーアプリ</p>
        </div>
        <!-- 左ハンバーガーボタン -->
        <button type="button" @click="openLeft = !openLeft"
            class="absolute top-0 left-0 flex flex-col justify-center items-center w-20 h-20 bg-main z-50 md:hidden">
            <div class="relative w-20 h-20">
                <span
                    class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
                    :class="openLeft ? '-translate-x-1/2 -translate-y-0 rotate-45' : '-translate-x-1/2 -translate-y-3 rotate-0'">
                </span>
                <span
                    class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
                    :class="openLeft ? 'opacity-0' : 'opacity-100 -translate-x-1/2'">
                </span>
                <span
                    class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
                    :class="openLeft ? '-translate-x-1/2 -translate-y-0 -rotate-45' : '-translate-x-1/2 translate-y-3 rotate-0'">
                </span>
            </div>
        </button>

        <!-- 右アカウントメニューボタン -->
        <button x-show="!openRight" type="button" @click="openRight = !openRight"
            class="absolute top-0 right-0 flex flex-col justify-center items-center w-20 h-20  z-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#f89900" viewBox="0 0 24 24" stroke="#f89900"
                class=" w-14 h-14">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z">
                    </path>
                </g>
            </svg>
        </button>
        <button x-show="openRight" type="button" @click="openRight = !openRight"
            class="absolute top-0 right-0 flex flex-col justify-center items-center w-20 h-20  z-50"
            style="display: none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffff" viewBox="0 0 24 24" stroke="#ffff" class="w-14 h-14">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z">
                    </path>
                </g>
            </svg>
        </button>
    </div>

    <!-- 左メニュー(レスポンシブハンバーガーメニュー) -->
    <div class="fixed top-0 left-0 w-max h-screen pt-20 bg-transparent z-40 flex flex-col max-md:hidden">
        <div class="absolute top-20 left-full h-[calc(100%-80px)] border border-r-main"></div>
        <nav class="flex flex-col px-5 mt-8 space-y-8">
            <a href="#" class="text-main text-2xl font-bold">献立表</a>
            <a href="#" class="text-main text-2xl font-bold">料理登録</a>
            <a href="#" class="text-main text-2xl font-bold">離乳食登録</a>
            <a href="#" class="text-main text-2xl font-bold">買い物リスト</a>
        </nav>
    </div>
    <div x-show="openLeft" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-64 h-screen pt-20 bg-main shadow-lg z-40 flex flex-col rounded-r-xl md:hidden"
        @click.away="openLeft = false" style="display: none;">
        <nav class="flex flex-col px-5 mt-8 space-y-8">
            <a href="#" class="text-subtext text-2xl font-bold">献立表</a>
            <a href="#" class="text-subtext text-2xl font-bold">料理登録</a>
            <a href="#" class="text-subtext text-2xl font-bold">離乳食登録</a>
            <a href="#" class="text-subtext text-2xl font-bold">買い物リスト</a>
        </nav>
    </div>

    <!-- 右スライドインメニュー -->
    <div x-show="openRight" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-64 h-screen pt-20 bg-main shadow-lg z-40 flex flex-col rounded-l-xl"
        @click.away="openRight = false" style="display: none;">
        <nav class="flex flex-col px-5 mt-8 space-y-8">
            <a href="#" class="text-subtext text-2xl font-bold">アカウント名変更</a>
            <a href="#" class="text-subtext text-2xl font-bold">メールアドレス変更</a>
            <a href="#" class="text-subtext text-2xl font-bold">パスワード変更</a>
            <nav class="flex mr-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"
                        class="text-subtext text-2xl font-bold">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </nav>
        </nav>
    </div>
</header>
