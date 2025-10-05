<header x-data="{ openLeft: false, openRight: false }" class="fixed top-0 left-0 w-screen h-20 bg-white border-b border-main z-50">
    <div class="h-full flex justify-between items-center w-11/12 mx-auto">
        <div class="pl-28 text-main flex items-end max-md:block">
            <h1 class="mr-4 font-monoton text-4xl leading-none max-md:text-3xl">Fameal</h1>
            <p class="max-md:text-sm">親子献立カレンダーアプリ</p>
        </div>
    </div>
    <!-- 左ハンバーガーボタン -->
    @include('layouts.partials.components.hum-button')
    <!-- 右アカウントメニューボタン -->
    @include('layouts.partials.components.account-button')
    <!-- 左メニュー(レスポンシブハンバーガーメニュー) -->
    @include('layouts.partials.components.nav-menu')
    <!-- 右スライドインメニュー -->
    @include('layouts.partials.components.account-menu')
</header>
