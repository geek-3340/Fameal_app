<nav class="fixed z-40 top-0 left-0 flex flex-col w-48 h-screen mt-20 pt-8 pl-4 bg-white border border-r-main max-xl:hidden"
    id="js-left-menu">
    <a href="{{ route('menus.index', ['category' => 'dishes','viewType' => 'month']) }}"
        class="text-main text-xl font-bold block w-max px-2 py-1 mb-4">献立表</a>
    <a href="{{ route('dishes.index') }}" class="text-main text-xl font-bold block w-max px-2 py-1 mb-4">料理登録</a>
    <a href="{{ route('babyfoods.index') }}" class="text-main text-xl font-bold block w-max px-2 py-1 mb-4">離乳食登録</a>
    <a href="{{ route('shopping.list.index') }}" class="text-main text-xl font-bold block w-max px-2 py-1">買い物リスト</a>
</nav>

<nav x-show="openNavMenu" x-cloak @click.away="openNavMenu = false" @keydown.escape.window="openNavMenu = false"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
    class="fixed z-40 top-0 left-0 flex flex-col w-48 h-screen pt-28 pl-4 bg-main shadow-lg rounded-r-xl xl:hidden">
    <a href="{{ route('menus.index', ['category' => 'dishes','viewType' => 'month']) }}" class="text-white text-xl font-bold mb-4">献立表</a>
    <a href="{{ route('dishes.index') }}" class="text-white text-xl font-bold mb-4">料理登録</a>
    <a href="{{ route('babyfoods.index') }}" class="text-white text-xl font-bold mb-4">離乳食登録</a>
    <a href="{{ route('shopping.list.index') }}" class="text-white text-xl font-bold">買い物リスト</a>
</nav>
