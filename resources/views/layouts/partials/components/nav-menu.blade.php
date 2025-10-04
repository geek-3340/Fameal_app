<div id="js-left-menu">
    <div class="fixed top-0 left-0 w-48 h-screen pt-20 z-40 flex flex-col max-md:hidden">
        <div class="absolute top-20 left-full h-[calc(100%-80px)] border border-r-main"></div>
        <nav class="flex flex-col px-5 mt-8 space-y-8">
            <a href="{{ route('menus.month.index') }}" class="text-main text-2xl font-bold block w-max px-2 py-1">献立表</a>
            <a href="{{ route('dishes.index') }}" class="text-main text-2xl font-bold block w-max px-2 py-1">料理登録</a>
            {{-- <a href="#" class="text-main text-2xl font-bold block w-max px-2 py-1">離乳食登録</a>
            <a href="#" class="text-main text-2xl font-bold block w-max px-2 py-1">買い物リスト</a> --}}
        </nav>
    </div>
</div>
<div x-show="openLeft" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 w-64 h-screen pt-20 bg-main shadow-lg z-40 flex flex-col rounded-r-xl md:hidden"
    @click.away="openLeft = false" style="display: none;">
    <nav class="flex flex-col px-5 mt-8 space-y-8">
        <a href="{{ route('menus.month.index') }}" class="text-white text-2xl font-bold">献立表</a>
        <a href="{{ route('dishes.index') }}" class="text-white text-2xl font-bold">料理登録</a>
        {{-- <a href="#" class="text-white text-2xl font-bold">離乳食登録</a>
            <a href="#" class="text-white text-2xl font-bold">買い物リスト</a> --}}
    </nav>
</div>
