<header x-data="{ openLeft: false, openRight: false }" class="fixed top-0 left-0 w-screen h-20 border-b border-filter z-50">
    <div class="h-full flex justify-between items-center w-11/12 mx-auto">
        <div class="flex items-end">
            <h1 class="ml-28 mr-3 font-monoton text-main text-4xl leading-none">Fameal</h1>
            <p class="text-main text-base leading-6">親子献立カレンダーアプリ</p>
        </div>
        <!-- 左ハンバーガーボタン -->
        <button type="button" @click="openLeft = true"
            class="absolute top-0 left-0 flex flex-col justify-center items-center w-20 h-20 bg-main">
            <span class="block w-10 h-1 rounded-lg bg-white mb-2"></span>
            <span class="block w-10 h-1 rounded-lg bg-white mb-2"></span>
            <span class="block w-10 h-1 rounded-lg bg-white"></span>
        </button>
        <!-- 右ハンバーガーボタン -->
        <button type="button" @click="openRight = true"
            class="absolute top-0 right-0 flex flex-col justify-center items-center w-20 h-20">
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
    </div>

    <!-- 左スライドインメニュー -->
    <div x-show="openLeft" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-64 h-screen bg-main shadow-lg z-50 flex flex-col rounded-r-xl"
        @click.away="openLeft = false" style="display: none;">
        <button @click="openLeft = false" class="self-end m-4 text-subtext text-2xl">&times;</button>
        <nav class="flex flex-col px-8 mt-8 space-y-4">
            <a href="#" class="text-subtext text-lg">メニュー1</a>
            <a href="#" class="text-subtext text-lg">メニュー2</a>
            <a href="#" class="text-subtext text-lg">メニュー3</a>
        </nav>
    </div>
    <!-- 右スライドインメニュー -->
    <div x-show="openRight" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-64 h-screen bg-main shadow-lg z-50 flex flex-col rounded-l-xl"
        @click.away="openRight = false" style="display: none;">
        <button @click="openRight = false" class="self-end m-4 text-subtext text-2xl">&times;</button>
        <nav class="flex flex-col px-8 mt-8 space-y-4">
            <a href="#" class="text-subtext text-lg">メニュー1</a>
            <a href="#" class="text-subtext text-lg">メニュー2</a>
            <nav class="flex mr-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"
                        class="text-subtext text-lg">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </nav>
        </nav>
    </div>
</header>
